<?php

namespace App\modelos;

use App\modelos\DbSistem;
use App\modelos\ModeloFactura;
use Exception;
use PDO;

class ModeloHospitalizacion extends DbSistem
{

    private $conexion;
    private $modeloFactura;
    public function __construct()
    {
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();

        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
        $this->modeloFactura = new ModeloFactura(); // Guarda la instancia de la conexión
    }

    // selecciono 6 tablas de la base de datos con el INNER JOIN, uso solo los datos que necesito, para mostrarlo en la tabla de la vista (de las hospitalizaciones pendientes)
    public function selectsH()
    {

        $consulta = $this->conexion->prepare('SELECT h.id_hospitalizacion, h.fecha_hora_inicio, h.precio_horas, h.fecha_hora_final, h.total, con.id_control, con.diagnostico, con.historiaclinica, pac.id_paciente, pac.nacionalidad, pac.cedula, pac.nombre, pac.apellido, u.id_usuario, pe.nombre AS nombredoc, pe.apellido AS apellidodoc FROM hospitalizacion h INNER JOIN control con ON h.id_control = con.id_control INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.id_usuario = u.id_usuario INNER JOIN personal_has_serviciomedico psm ON psm.personal_id_personal = pe.id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico WHERE con.estado = "ACT" AND sm.estado = "ACT" AND u.estado = "ACT" AND h.estado = "Pendiente" GROUP BY h.id_hospitalizacion');

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }
    // selecciono 6 tablas de la base de datos con el INNER JOIN, uso solo los datos que necesito, para mostrarlo en la tabla de la vista (de las hospitalizaciones realizadas)
    public function selectsHR()
    {

        $consulta = $this->conexion->prepare('SELECT h.id_hospitalizacion, h.fecha_hora_inicio, h.precio_horas, h.fecha_hora_final, h.total, con.id_control, con.diagnostico, con.historiaclinica, pac.id_paciente, pac.nacionalidad, pac.cedula, pac.nombre, pac.apellido, u.id_usuario, pe.nombre AS nombredoc, pe.apellido AS apellidodoc FROM hospitalizacion h INNER JOIN control con ON h.id_control = con.id_control INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.id_usuario = u.id_usuario INNER JOIN personal_has_serviciomedico psm ON psm.personal_id_personal = pe.id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico WHERE h.estado = "Realizada" GROUP BY h.id_hospitalizacion;');

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    // validamos si el paciente existe
    public function validarPacienteH($cedula)
    {

        $consulta = $this->conexion->prepare('SELECT cedula, nombre, apellido FROM paciente WHERE cedula = :cedula AND estado= "ACT"');

        $consulta->bindValue(":cedula", $cedula, PDO::PARAM_INT);

        return ($consulta->execute()) ? $consulta->fetch() : false;
    }


    // validamos si el control del paciente existe
    public function validarControlPaciente($cedula)
    {

        $consulta = $this->conexion->prepare('SELECT con.id_control, pac.cedula, pac.nombre, pac.apellido FROM control con INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente WHERE pac.cedula = :cedula AND pac.estado = "ACT" ORDER BY con.id_control DESC LIMIT 1');

        $consulta->bindParam(":cedula", $cedula);

        return ($consulta->execute()) ? $consulta->fetch() : false;
    }

    // selecciono 6 tablas de la base de datos con el INNER JOIN, uso solo los datos que necesito.
    // selecciono el control de un paciente.
    public function select($cedula)
    {

        $consulta = $this->conexion->prepare('SELECT con.id_control, con.historiaclinica, con.diagnostico, pac.id_paciente, pac.cedula, pac.nombre, pac.apellido, u.id_usuario, pe.nombre AS nombredoc, pe.apellido AS apellidodoc FROM control con INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN segurity.usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.usuario = u.id_usuario INNER JOIN personal_has_serviciomedico psm ON psm.personal_id_personal = pe.id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico WHERE pac.cedula = :cedula AND con.estado = "ACT" AND sm.estado = "ACT" AND u.estado = "ACT" ORDER by con.id_control DESC LIMIT 1');

        $consulta->bindParam(":cedula", $cedula);

        return ($consulta->execute()) ? $consulta->fetch() : false;
    }

    // selecciono todos los insumos
    public function selectsInsumos()
    {

        $consulta = $this->conexion->prepare('SELECT ins.*, inv.cantidad_disponible AS cantidad FROM insumo ins INNER JOIN entrada_insumo inv ON inv.id_insumo = ins.id_insumo WHERE estado = "ACT" AND inv.cantidad_disponible > 0');

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    // buscar insumos por nombre
    public function buscarInsumos($nombre)
    {

        $consulta = $this->conexion->prepare('SELECT ins.*, inv.* FROM insumo ins INNER JOIN inventario inv ON inv.id_insumo = ins.id_insumo WHERE estado = "ACT" AND inv.cantidad > 0 AND nombre LIKE :nombre');

        //PDO::PARAM_STR: esto es para que el envió sea de tipo estrin. 
        //bindValue: funciona igual que el bindParam la diferencia es, que después del bindValue no se puede modificar nada de la consulta no lo leerá.
        $consulta->bindValue(":nombre", '%' . $nombre . '%', PDO::PARAM_STR);

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function buscarUnInsumo($id)
    {

        $consulta = $this->conexion->prepare('SELECT ins.id_insumo, ins.nombre, ins.precio, inv.cantidad AS limite_insumo FROM insumo ins INNER JOIN inventario inv ON inv.id_insumo = ins.id_insumo WHERE ins.estado = "ACT" AND ins.id_insumo = :id');

        //PDO::PARAM_INT: esto es para que el envió sea de tipo entero. 
        //bindValue: funciona igual que el bindParam la diferencia es, que después del bindValue no se puede modificar nada de la consulta no lo leerá.
        $consulta->bindValue(":id", $id, PDO::PARAM_INT);

        return ($consulta->execute()) ? $consulta->fetch() : false;
    }

    // verifica si la hospitalización existe
    public function verificaHA($idC)
    {
        try {
            $consulta = $this->conexion->prepare('SELECT id_hospitalizacion FROM hospitalizacion WHERE id_control = :id_c AND estado = "Pendiente"');

            $consulta->bindParam(":id_c", $idC);
            $consulta->execute();
            return ($consulta->fetch()) ? true : false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function updateHistorial($idControl, $historial)
    {
        $consulta = $this->conexion->prepare('UPDATE control SET historiaclinica= :historial WHERE id_control = :id_control;');
        $consulta->bindParam(":historial", $historial);
        $consulta->bindParam(":id_control", $idControl);
        $consulta->execute();
    }

    public function insertarH($idControl, $fechaHora, $idInsumos, $cantidad, $historial)
    {
        try {
            $this->conexion->beginTransaction();

            // insertar hospitalización
            $consulta = $this->conexion->prepare('INSERT INTO hospitalizacion(fecha_hora_inicio, precio_horas, precio_horas_MoEx, total, total_MoEx, id_control, fecha_hora_final, estado) VALUES ( :fecha_hora_inicio, "null", "null", "null", "null", :id_control,  "null", "Pendiente")');
            $consulta->bindParam(":fecha_hora_inicio", $fechaHora);
            $consulta->bindParam(":id_control", $idControl);
            $consulta->execute();
            //devuelve el id de la hospitalización.
            //obtenemos los datos de la hospitalización que se a agregado. si no se inserta devuelve 0
            $idH = ($this->conexion->lastInsertId() === 0) ? false : $this->conexion->lastInsertId();

            // editar control
            $this->updateHistorial($idControl, $historial);


            // si hay un id del insumo devuelve verdadero si no, devuelve falso
            if ($idInsumos) {

                $contadorC = 0;

                foreach ($idInsumos as $idI) {

                    // selecciono id del inventario
                    $consulta = $this->conexion->prepare('SELECT inv.id_inventario FROM inventario inv INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE inv.id_insumo = :id_insumo AND inv.cantidad >= :cantidad LIMIT 1;');
                    $consulta->bindParam(":id_insumo", $idI);
                    $consulta->bindParam(":cantidad", $cantidad[$contadorC]);
                    $idInventario = ($consulta->execute()) ? $consulta->fetch() : false;


                    // insertar insumos de la hospitalización
                    $consulta = $this->conexion->prepare('INSERT INTO insumodehospitalizacion(id_hospitalizacion, id_inventario, cantidad) VALUES (:id_hospitalizacion, :id_inventario, :cantidad)');
                    $consulta->bindParam(":id_hospitalizacion", $idH);
                    $consulta->bindParam(":id_inventario", $idInventario["id_inventario"]);
                    $consulta->bindParam(":cantidad", $cantidad[$contadorC]);
                    $consulta->execute();

                    // seleccionamos la cantidad de la tabla de insumos
                    $cantidadITI = $this->buscarUnInsumo($idI);

                    // resta
                    $resultadoC = $cantidadITI["limite_insumo"] - $cantidad[$contadorC];

                    // editar la cantidad de insumos(tabla insumos)
                    $this->editarCDI($idI, $resultadoC);
                    // editar la cantidad de insumos(tabla inventario y entrada)
                    $this->modeloFactura->updateCantidadEntrada($idI, $cantidad[$contadorC]);
                    $contadorC++;
                }
            }

            $this->conexion->commit();
        } catch (\Exception $e) {
            $this->conexion->rollBack();
            print_r($e);
        }
    }


    // traer insumos por el id de la hospitalización
    public function EInsumosM($id)
    {

        $consulta = $this->conexion->prepare('SELECT h.id_hospitalizacion, idh.id_insumoDeHospitalizacion, ins.id_insumo, idh.cantidad, ins.nombre, ins.precio, h.fecha_hora_inicio, inv.cantidad AS limite_insumo FROM hospitalizacion h INNER JOIN control con ON h.id_control = con.id_control INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.id_usuario = u.id_usuario INNER JOIN personal_has_serviciomedico psm ON psm.personal_id_personal = pe.id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico INNER JOIN insumodehospitalizacion idh ON h.id_hospitalizacion = idh.id_hospitalizacion INNER JOIN inventario inv ON idh.id_inventario = inv.id_inventario INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE con.estado = "ACT" AND u.estado = "ACT" AND ins.estado = "ACT" AND h.id_hospitalizacion = :id GROUP BY ins.id_insumo');

        $consulta->bindValue(":id", $id, PDO::PARAM_INT);

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function editarH($duracion, $precioHoras, $total, $idInsumosA, $cantidadE, $cantidadA, $historial, $idHos, $idIDH, $idInsElim)
    {
        try {
            $this->conexion->beginTransaction();

            // consulta el id del control
            $consulta = $this->conexion->prepare('SELECT con.id_control FROM control con INNER JOIN hospitalizacion h ON h.id_control = con.id_control WHERE h.id_hospitalizacion = :idHosp;');
            $consulta->bindParam(":idHosp", $idHos);
            $idControl = ($consulta->execute()) ? $consulta->fetch() : false;
            // editar control
            $this->updateHistorial($idControl["id_control"], $historial);


            // es para a editar insumos
            // si hay un id del insumo de hospitalización devuelve verdadero si no, devuelve falso
            if ($idIDH) {

                $contador = 0;

                foreach ($idIDH as $idInDHos) {

                    // selecciono la cantidad del insumo existente de la hospitalización
                    $consulta = $this->conexion->prepare('SELECT idh.cantidad, ins.id_insumo FROM insumodehospitalizacion idh INNER JOIN inventario inv ON idh.id_inventario = inv.id_inventario INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE id_insumoDeHospitalizacion = :id');
                    $consulta->bindParam(":id", $idInDHos);
                    $cantidadIHBD = ($consulta->execute()) ? $consulta->fetch() : false;


                    // se edita los insumos de la hospitalización
                    $consulta = $this->conexion->prepare('UPDATE insumodehospitalizacion SET cantidad= :cantidad WHERE id_insumoDeHospitalizacion = :id_hdi');
                    $consulta->bindParam(":cantidad", $cantidadE[$contador]);
                    $consulta->bindParam(":id_hdi", $idInDHos);
                    $consulta->execute();

                    // seleccionamos la cantidad de la tabla de insumos
                    $cantidadITI = $this->buscarUnInsumo($cantidadIHBD["id_insumo"]);

                    // se resta si es mayor al mismo
                    if ($cantidadE[$contador] > $cantidadIHBD["cantidad"]) {

                        $cS = $cantidadE[$contador] - $cantidadIHBD["cantidad"];
                        // suma
                        $resultadoC = $cantidadITI["limite_insumo"] - $cS;
                        // editar la cantidad de insumos(tabla insumos)
                        $this->editarCDI($cantidadIHBD["id_insumo"], $resultadoC);

                        // se suma si es menor al mismo
                    } else if ($cantidadE[$contador] < $cantidadIHBD["cantidad"]) {

                        $cR = $cantidadIHBD["cantidad"] - $cantidadE[$contador];
                        // suma
                        $resultadoC = $cR + $cantidadITI["limite_insumo"];

                        // editar la cantidad de insumos(tabla insumos)
                        $this->editarCDI($cantidadIHBD["id_insumo"], $resultadoC);
                    }


                    $contador++;
                }
            }

            // es para agregar insumos
            // si hay un id del insumo devuelve verdadero si no, devuelve falso
            if ($idInsumosA) {

                $contadorC = 0;

                foreach ($idInsumosA as $idIA) {

                    // selecciono id del inventario
                    $consulta = $this->conexion->prepare('SELECT inv.id_inventario FROM inventario inv INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE inv.id_insumo = :id_insumo AND inv.cantidad >= :cantidad LIMIT 1;');
                    $consulta->bindParam(":id_insumo", $idIA);
                    $consulta->bindParam(":cantidad", $cantidadA[$contadorC]);
                    $idInventario = ($consulta->execute()) ? $consulta->fetch() : false;


                    // insertar insumos de la hospitalización
                    $consulta = $this->conexion->prepare('INSERT INTO insumodehospitalizacion(id_hospitalizacion, id_inventario, cantidad) VALUES (:id_hospitalizacion, :id_inventario, :cantidad)');
                    $consulta->bindParam(":id_hospitalizacion", $idHos);
                    $consulta->bindParam(":id_inventario", $idInventario["id_inventario"]);
                    $consulta->bindParam(":cantidad", $cantidadA[$contadorC]);
                    $consulta->execute();

                    // seleccionamos la cantidad de la tabla de insumos
                    $cantidadITI = $this->buscarUnInsumo($idIA);

                    // resta
                    $resultadoC = $cantidadITI["limite_insumo"] - $cantidadA[$contadorC];

                    // editar la cantidad de insumos(tabla insumos)
                    $this->editarCDI($idIA, $resultadoC);

                    $contadorC++;
                }
            }


            // es para eliminar insumos
            // si hay un id del insumo eliminado devuelve verdadero si no, devuelve falso
            if ($idInsElim) {

                $contador = 0;
                foreach ($idInsElim as $idIAEl) {

                    // selecciono la cantidad del insumo existente de la hospitalización
                    $consulta = $this->conexion->prepare('SELECT idh.cantidad, ins.id_insumo FROM insumodehospitalizacion idh INNER JOIN inventario inv ON idh.id_inventario = inv.id_inventario INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE id_insumoDeHospitalizacion = :id');
                    $consulta->bindParam(":id", $idIAEl);
                    $cantidadIH = ($consulta->execute()) ? $consulta->fetch() : false;

                    // seleccionamos la cantidad de la tabla de insumos
                    $cantidadITI = $this->buscarUnInsumo($cantidadIH["id_insumo"]);
                    // suma
                    $resultadoC = $cantidadIH["cantidad"] + $cantidadITI["limite_insumo"];

                    // editar la cantidad de insumos(tabla insumos)
                    $this->editarCDI($cantidadIH["id_insumo"], $resultadoC);


                    // elimina insumos de la hospitalización
                    $consulta = $this->conexion->prepare('DELETE FROM insumodehospitalizacion WHERE id_insumoDeHospitalizacion = :id_insumo_eliminado');
                    $consulta->bindParam(":id_insumo_eliminado", $idIAEl);
                    $consulta->execute();

                    $contador++;
                }
            }

            $this->conexion->commit();
        } catch (\Exception $e) {
            $this->conexion->rollBack();
            print_r($e);
        }
    }

    // eliminación lógica
    public function eliminaLogico($idH, $datosIDH)
    {
        try {
            $this->conexion->beginTransaction();

            // si hay un id del insumo devuelve verdadero si no, devuelve falso
            if ($datosIDH) {

                foreach ($datosIDH as $indice => $value) {

                    // seleccionamos la cantidad de la tabla de insumos
                    $cantidadITI = $this->buscarUnInsumo($value["id_insumo"]);
                    // suma
                    $resultadoC = $value["cantidad"] + $cantidadITI["limite_insumo"];

                    // editar la cantidad de insumos(tabla insumos)
                    $this->editarCDI($value["id_insumo"], $resultadoC);
                }
            }

            // editar el estado hospitalización
            $consulta = $this->conexion->prepare('UPDATE hospitalizacion SET estado ="DES" WHERE id_hospitalizacion =:id_h ;');

            $consulta->bindParam(":id_h", $idH);
            $consulta->execute();

            $this->conexion->commit();
        } catch (\Exception $e) {
            $this->conexion->rollBack();
            print_r($e);
        }
    }

    // editar la cantidad de insumos(tabla insumos)
    public function editarCDI($idI, $cantidadI)
    {
        $consulta = $this->conexion->prepare('UPDATE inventario SET cantidad = :cantidad WHERE id_insumo = :id_insumo;');
        $consulta->bindParam(":id_insumo", $idI);
        $consulta->bindParam(":cantidad", $cantidadI);
        $consulta->execute();
    }


    // buscar insumos de las hospitalizaciones existentes 
    public function buscarIEH()
    {
        $consulta = $this->conexion->prepare('SELECT h.id_hospitalizacion, idh.id_insumoDeHospitalizacion, ins.id_insumo, idh.cantidad, ins.nombre, inv.cantidad AS cantidadEx, ins.precio, h.fecha_hora_inicio FROM hospitalizacion h INNER JOIN control con ON h.id_control = con.id_control INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.id_usuario = u.id_usuario INNER JOIN personal_has_serviciomedico psm ON psm.personal_id_personal = pe.id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico INNER JOIN insumodehospitalizacion idh ON h.id_hospitalizacion = idh.id_hospitalizacion INNER JOIN inventario inv ON idh.id_inventario = inv.id_inventario INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE con.estado = "ACT" AND sm.estado = "ACT" AND u.estado = "ACT" AND ins.estado = "ACT" AND h.estado = "Pendiente"');

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function facturarH($idH, $fechaHoraFinal, $monto, $montoME,  $total, $totalME)
    {
        // try {

        // editar hospitalización
        $consulta = $this->conexion->prepare("UPDATE hospitalizacion SET precio_horas = :precio_horas ,precio_horas_MoEx = :precio_horas_me ,total= :total ,total_MoEx = :total_me ,fecha_hora_final = :fecha_hora_final WHERE id_hospitalizacion = :id_hospitalizacion");
        $consulta->bindParam(":precio_horas", $monto);
        $consulta->bindParam(":precio_horas_me", $montoME);
        $consulta->bindParam(":total", $total);
        $consulta->bindParam(":total_me", $totalME);
        $consulta->bindParam(":fecha_hora_final", $fechaHoraFinal);
        $consulta->bindParam(":id_hospitalizacion", $idH);
        return ($consulta->execute()) ? true : false;

        // } catch (\Exception $e) {
        // print_r("ocurrio un error en hospitalización, intente mas tarde");
        // }
    }
    public function semaforo()
    {
        // try {

        // verifica cuantas hospitalizaciones hay pendiente
        $consulta = $this->conexion->prepare("SELECT COUNT(*) FROM hospitalizacion WHERE estado = 'Pendiente';");

        return ($consulta->execute()) ? $consulta->fetch() : false;

        // } catch (\Exception $e) {
        // print_r("ocurrio un error en hospitalización, intente mas tarde");
        // }
    }
}
