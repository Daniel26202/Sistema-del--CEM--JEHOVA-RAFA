<?php

namespace App\modelos;

use App\modelos\Db;
use Exception;
use PDO;

class ModeloHospitalizacion extends Db
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = $this->connectionSistema();
    }

    // selecciono 6 tablas de la base de datos con el INNER JOIN, uso solo los datos que necesito, para mostrarlo en la tabla de la vista (de las hospitalizaciones pendientes)
    public function selectsH()
    {

        $consulta = $this->conexion->prepare("SELECT h.id_hospitalizacion, h.fecha_hora_inicio, h.precio_horas, h.fecha_hora_final, h.total, con.id_control, con.diagnostico, con.historiaclinica, pac.id_paciente, pac.nacionalidad, pac.cedula, pac.nombre, pac.apellido, u.id_usuario, pe.nombre AS nombredoc, pe.apellido AS apellidodoc FROM hospitalizacion h INNER JOIN paciente pac ON h.id_paciente = pac.id_paciente INNER JOIN control con ON con.id_control = (SELECT con2.id_control FROM control con2 WHERE con2.id_paciente = pac.id_paciente AND con2.estado = 'DES' ORDER BY con2.id_control DESC LIMIT 1) INNER JOIN segurity.usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.usuario = u.id_usuario INNER JOIN personal_has_serviciomedico psm ON psm.personal_id_personal = pe.id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico WHERE sm.estado = 'ACT' AND u.estado = 'ACT' AND h.estado = 'Pendiente' GROUP BY h.id_hospitalizacion;");

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function selectDoctores()
    {
        $consulta = $this->conexion->prepare("SELECT DISTINCT p.nombre, p.apellido, p.id_personal FROM personal p JOIN personal_has_serviciomedico phs ON phs.personal_id_personal = p.id_personal JOIN horarioydoctor hd ON hd.id_personal = p.id_personal JOIN horario h ON h.id_horario = hd.id_horario JOIN serviciomedico sm ON sm.id_servicioMedico = phs.serviciomedico_id_servicioMedico WHERE sm.estado = 'ACT' 
        AND (sm.tipo = 'Examenes' OR ( h.diaslaborables = (
                                            CASE DAYOFWEEK(CURDATE())
                                                WHEN 1 THEN 'domingo'
                                                WHEN 2 THEN 'lunes'
                                                WHEN 3 THEN 'martes'
                                                WHEN 4 THEN 'miércoles'
                                                WHEN 5 THEN 'jueves'
                                                WHEN 6 THEN 'viernes'
                                                WHEN 7 THEN 'sábado'
                                            END
                                        )
                                        AND CURTIME() BETWEEN hd.horaDeEntrada AND hd.horaDeSalida
                                    )
        );");

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function selectServiciosDH($idH)
    {
        $consulta = $this->conexion->prepare("SELECT * FROM servicios_hospitalizacion WHERE id_hospitalizacion = :id_hospitalizacion;");
        $consulta->bindParam(":id_hospitalizacion", $idH);
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function selectServiciosD()
    {
        $consulta = $this->conexion->prepare("SELECT DISTINCT sm.tipo, sm.precio, cs.nombre AS categoria, p.nombre, p.apellido, sm.id_servicioMedico, sm.tipo FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria INNER JOIN personal_has_serviciomedico phs ON phs.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN personal p ON p.id_personal = phs.personal_id_personal INNER JOIN horarioydoctor hd ON hd.id_personal = p.id_personal INNER JOIN horario h ON h.id_horario = hd.id_horario WHERE sm.estado = 'ACT'
        AND (sm.tipo = 'Examenes' OR (
                        h.diaslaborables = (
                            CASE DAYOFWEEK(CURDATE())
                                WHEN 1 THEN 'domingo'
                                WHEN 2 THEN 'lunes'
                                WHEN 3 THEN 'martes'
                                WHEN 4 THEN 'miércoles'
                                WHEN 5 THEN 'jueves'
                                WHEN 6 THEN 'viernes'
                                WHEN 7 THEN 'sábado'
                            END
                        )
                        AND CURTIME() BETWEEN hd.horaDeEntrada AND hd.horaDeSalida
                    )
            );");

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    // selecciono 6 tablas de la base de datos con el INNER JOIN, uso solo los datos que necesito, para mostrarlo en la tabla de la vista (de las hospitalizaciones realizadas)
    public function selectsHR()
    {

        $consulta = $this->conexion->prepare("SELECT h.id_hospitalizacion, h.fecha_hora_inicio, h.precio_horas, h.fecha_hora_final, h.total, con.id_control, con.diagnostico, con.historiaclinica, pac.id_paciente, pac.nacionalidad, pac.cedula, pac.nombre, pac.apellido, u.id_usuario, pe.nombre AS nombredoc, pe.apellido AS apellidodoc FROM hospitalizacion h INNER JOIN paciente pac ON h.id_paciente = pac.id_paciente INNER JOIN control con ON con.id_paciente = pac.id_paciente INNER JOIN segurity.usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.usuario = u.id_usuario INNER JOIN personal_has_serviciomedico psm ON psm.personal_id_personal = pe.id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico WHERE h.estado = 'Realizada' GROUP BY h.id_hospitalizacion;");

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    // validamos si el paciente existe
    public function validarPacienteH($cedula)
    {

        $consulta = $this->conexion->prepare('SELECT cedula, id_paciente, nombre, apellido FROM paciente WHERE cedula = :cedula AND estado= "ACT"');

        $consulta->bindValue(":cedula", $cedula, PDO::PARAM_INT);

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

        $consulta = $this->conexion->prepare('SELECT ins.*, sum(inv.cantidad_disponible) AS cantidad FROM insumo ins INNER JOIN entrada_insumo inv ON inv.id_insumo = ins.id_insumo WHERE estado = "ACT" AND inv.cantidad_disponible > 0 GROUP BY inv.id_insumo');

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    // buscar insumos por nombre
    public function buscarInsumos($nombre)
    {

        $consulta = $this->conexion->prepare('SELECT ins.*, en_in.* FROM insumo ins INNER JOIN entrada_insumo en_in ON en_in.id_insumo = ins.id_insumo WHERE ins.estado = "ACT" AND en_in.cantidad_disponible > 0 AND ins.nombre LIKE :nombre;');

        //PDO::PARAM_STR: esto es para que el envió sea de tipo estrin. 
        //bindValue: funciona igual que el bindParam la diferencia es, que después del bindValue no se puede modificar nada de la consulta no lo leerá.
        $consulta->bindValue(":nombre", '%' . $nombre . '%', PDO::PARAM_STR);

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function buscarUnInsumo($id)
    {

        $consulta = $this->conexion->prepare('SELECT ins.id_insumo, inv.id_entradaDeInsumo, ins.nombre, ins.precio, sum(inv.cantidad_disponible) AS limite_insumo FROM insumo ins INNER JOIN entrada_insumo inv ON inv.id_insumo = ins.id_insumo INNER JOIN entrada e ON e.id_entrada = inv.id_entrada  WHERE ins.estado = "ACT" AND ins.id_insumo =:id ORDER BY e.fechaDeIngreso');

        //PDO::PARAM_INT: esto es para que el envió sea de tipo entero. 
        //bindValue: funciona igual que el bindParam la diferencia es, que después del bindValue no se puede modificar nada de la consulta no lo leerá.
        $consulta->bindValue(":id", $id, PDO::PARAM_INT);

        return ($consulta->execute()) ? $consulta->fetch() : false;
    }

    // verifica si la hospitalización existe
    public function verificaHA($id_paciente, $id_personal)
    {
        try {
            $consulta = $this->conexion->prepare('SELECT id_hospitalizacion FROM hospitalizacion WHERE id_paciente = :id_paciente AND personal_id_personal = :id_personal AND estado = "Pendiente";');

            $consulta->bindParam(":id_paciente", $id_paciente);
            $consulta->bindParam(":id_personal", $id_personal);
            $consulta->execute();
            return ($consulta->fetch()) ? true : false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function insertarH($fechaHora, $idInsumos, $cantidad, $historial, $idPersonal, $idPaciente, $severidad, $cantidadS, $idServicio, $diagnostico)
    {
        try {
            $this->conexion->beginTransaction();

            // insertar hospitalización
            $consulta = $this->conexion->prepare('INSERT INTO hospitalizacion (fecha_hora_inicio, precio_horas, precio_horas_MoEx, total, total_MoEx, id_paciente, fecha_hora_final, estado, personal_id_personal)  VALUES (:fecha_hora_inicio, "", "", "", "", :id_paciente, "", "Pendiente", :id_personal);');
            $consulta->bindParam(":fecha_hora_inicio", $fechaHora);
            $consulta->bindParam(":id_paciente", $idPaciente);
            $consulta->bindParam(":id_personal", $idPersonal);
            $consulta->execute();
            //devuelve el id de la hospitalización.
            //obtenemos los datos de la hospitalización que se a agregado. si no se inserta devuelve 0
            $idH = ($this->conexion->lastInsertId() === 0) ? false : $this->conexion->lastInsertId();

            // si hay un id del insumo devuelve verdadero si no, devuelve falso
            if ($idInsumos) {

                $contadorC = 0;

                foreach ($idInsumos as $idI) {

                    // selecciono id de entrada_insumo
                    $consulta = $this->conexion->prepare('SELECT inv.id_entradaDeInsumo FROM entrada_insumo inv INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo INNER JOIN entrada e ON e.id_entrada= inv.id_entrada WHERE inv.id_insumo =:id_insumo AND inv.cantidad_disponible >= :cantidad ORDER BY e.fechaDeIngreso LIMIT 1;');
                    $consulta->bindParam(":id_insumo", $idI);
                    $consulta->bindParam(":cantidad", $cantidad[$contadorC]);
                    $idEntradaDeInsumo = ($consulta->execute()) ? $consulta->fetch() : false;


                    // insertar insumos de la hospitalización
                    $consulta = $this->conexion->prepare('INSERT INTO insumodehospitalizacion(id_hospitalizacion, id_entradaDeInsumo, cantidad) VALUES (:id_hospitalizacion, :id_entradaDeInsumo, :cantidad)');
                    $consulta->bindParam(":id_hospitalizacion", $idH);
                    $consulta->bindParam(":id_entradaDeInsumo", $idEntradaDeInsumo["id_entradaDeInsumo"]);
                    $consulta->bindParam(":cantidad", $cantidad[$contadorC]);

                    if ($consulta->execute()) {
                        $consulta2 =  $this->conexion->prepare("CALL DescontarLotes(:i, :cantidad);");
                        $consulta2->bindParam(":i", $idI);
                        $consulta2->bindParam(":cantidad", $cantidad[$contadorC]);
                        $consulta2->execute();
                    }

                    $contadorC++;
                }
            }
            // si hay un id del servicio devuelve verdadero si no, devuelve falso
            if ($idServicio) {

                $contador = 0;
                foreach ($idServicio as $idS) {

                    // insertar servicio de la hospitalización
                    $consulta = $this->conexion->prepare("INSERT INTO servicios_hospitalizacion(id_hospitalizacion, id_servicioMedico, cantidad) VALUES (:id_hospitalizacion, :id_servicioMedico, :cantidad)");
                    $consulta->bindParam(":id_hospitalizacion", $idH);
                    $consulta->bindParam(":id_servicioMedico", $idS);
                    $consulta->bindParam(":cantidad", $cantidadS[$contador]);
                    $consulta->execute();

                    $contador++;
                }
            }

            // seleccionamos el id del
            $consulta = $this->conexion->prepare("SELECT u.id_usuario FROM segurity.usuario u JOIN bd.personal p ON p.usuario = u.id_usuario WHERE p.id_personal = :id_personal LIMIT 1");
            $consulta->bindParam(":id_personal", $idPersonal);
            $idUsuario = ($consulta->execute()) ? $consulta->fetch() : false;

            // insertar control
            $consulta = $this->conexion->prepare("INSERT INTO control (id_paciente, id_usuario, diagnostico, medicamentosRecetados, fecha_control, fechaRegreso, nota, historiaclinica, estado, severidad) VALUES (:id_paciente, :id_usuario, :diagnostico, '', :fecha_control, '', '', :historial, 'DES', :severidad);");
            $consulta->bindParam(":id_paciente", $idPaciente);
            $consulta->bindParam(":id_usuario", $idUsuario["id_usuario"]);
            $consulta->bindParam(":diagnostico", $diagnostico);
            $consulta->bindParam(":historial", $historial);
            $consulta->bindParam(":fecha_control", $fechaHora);
            $consulta->bindParam(":severidad", $severidad);
            $consulta->execute();

            $this->conexion->commit();
            return "exito";
        } catch (\Exception $e) {
            $this->conexion->rollBack();
            print_r($e);
        }
    }


    // traer insumos por el id de la hospitalización
    public function EInsumosM($id)
    {

        $consulta = $this->conexion->prepare("SELECT h.id_hospitalizacion, idh.id_insumoDeHospitalizacion, ins.id_insumo, idh.cantidad, ins.nombre, ins.precio, h.fecha_hora_inicio, inv.cantidad_disponible AS limite_insumo FROM hospitalizacion h INNER JOIN paciente pac ON h.id_paciente = pac.id_paciente INNER JOIN control con ON con.id_paciente = pac.id_paciente INNER JOIN segurity.usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.usuario = u.id_usuario INNER JOIN personal_has_serviciomedico psm ON psm.personal_id_personal = pe.id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico INNER JOIN insumodehospitalizacion idh ON h.id_hospitalizacion = idh.id_hospitalizacion INNER JOIN entrada_insumo inv ON idh.id_entradaDeInsumo = inv.id_entradaDeInsumo INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE con.estado = 'DES' AND u.estado = 'ACT' AND ins.estado = 'ACT' AND h.id_hospitalizacion = :id GROUP BY ins.id_insumo;");

        $consulta->bindValue(":id", $id, PDO::PARAM_INT);

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function datosControl($idH)
    {
        // consulta el id del control
        $consulta = $this->conexion->prepare("SELECT con.id_control, con.id_paciente FROM control con INNER JOIN hospitalizacion h ON h.id_paciente = con.id_paciente WHERE h.id_hospitalizacion = :idHosp ORDER by con.id_control DESC LIMIT 1;");
        $consulta->bindParam(":idHosp", $idH);
        return ($consulta->execute()) ? $consulta->fetch() : false;
    }

    public function editarH($idInsumosA, $cantidadE, $cantidadA, $historial, $idHos, $idIDH, $idInsElim, $diagnostico, $idServicio, $cantidadS)
    {
        try {
            $this->conexion->beginTransaction();

            // consulta el id del control
            $idControl = $this->datosControl($idHos);

            // editar control
            $consulta = $this->conexion->prepare('UPDATE control SET historiaclinica = :historial, diagnostico = :diagnostico WHERE id_control = :id_control;');
            $consulta->bindParam(":historial", $historial);
            $consulta->bindParam(":diagnostico", $diagnostico);
            $consulta->bindParam(":id_control", $idControl["id_control"]);
            $consulta->execute();

            // es para a editar insumos
            // si hay un id del insumo de hospitalización devuelve verdadero si no, devuelve falso
            if ($idIDH) {

                $contador = 0;

                foreach ($idIDH as $idInDHos) {

                    // selecciono la cantidad del insumo existente de la hospitalización
                    $consulta = $this->conexion->prepare('SELECT idh.cantidad, ins.id_insumo FROM insumodehospitalizacion idh INNER JOIN entrada_insumo inv ON idh.id_entradaDeInsumo = inv.id_entradaDeInsumo INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE id_insumoDeHospitalizacion = :id');
                    $consulta->bindParam(":id", $idInDHos);
                    $cantidadIHBD = ($consulta->execute()) ? $consulta->fetch() : false;

                    // se edita los insumos de la hospitalización
                    $consulta = $this->conexion->prepare('UPDATE insumodehospitalizacion SET cantidad= :cantidad WHERE id_insumoDeHospitalizacion = :id_hdi');
                    $consulta->bindParam(":cantidad", $cantidadE[$contador]);
                    $consulta->bindParam(":id_hdi", $idInDHos);

                    if ($consulta->execute()) {

                        // se resta al inventario (suma a los insumos de hospitalización)
                        if ($cantidadE[$contador] > $cantidadIHBD["cantidad"]) {

                            $cS = $cantidadE[$contador] - $cantidadIHBD["cantidad"];

                            $consulta2 =  $this->conexion->prepare("CALL DescontarLotes(:i, :cantidad);");
                            $consulta2->bindParam(":i", $cantidadIHBD["id_insumo"]);
                            $consulta2->bindParam(":cantidad", $cS);
                            $consulta2->execute();
                            $consulta2->closeCursor();


                            // se suma al inventario (resta a los insumos de hospitalización)
                        } else if ($cantidadE[$contador] < $cantidadIHBD["cantidad"]) {

                            $cR = $cantidadIHBD["cantidad"] - $cantidadE[$contador];
                            $consulta2 =  $this->conexion->prepare("CALL devolver_insumo_hospitalizacion(:i, :cantidad);");
                            $consulta2->bindParam(":i", $cantidadIHBD["id_insumo"]);
                            $consulta2->bindParam(":cantidad", $cR);
                            $consulta2->execute();
                            $consulta2->closeCursor();
                        }
                    }




                    $contador++;
                }
            }

            // es para agregar insumos
            // si hay un id del insumo devuelve verdadero si no, devuelve falso
            if ($idInsumosA) {

                $contadorC = 0;

                foreach ($idInsumosA as $idIA) {

                    // selecciono id de entrada_insumo
                    $consulta = $this->conexion->prepare('SELECT inv.id_entradaDeInsumo FROM entrada_insumo inv INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo INNER JOIN entrada e ON e.id_entrada= inv.id_entrada WHERE inv.id_insumo =:id_insumo AND inv.cantidad_disponible >= :cantidad ORDER BY e.fechaDeIngreso LIMIT 1;');
                    $consulta->bindParam(":id_insumo", $idIA);
                    $consulta->bindParam(":cantidad", $cantidadA[$contadorC]);
                    $idEntradaDeInsumo = ($consulta->execute()) ? $consulta->fetch() : false;


                    // insertar insumos de la hospitalización
                    $consulta = $this->conexion->prepare('INSERT INTO insumodehospitalizacion(id_hospitalizacion, id_entradaDeInsumo, cantidad) VALUES (:id_hospitalizacion, :id_entradaDeInsumo, :cantidad)');
                    $consulta->bindParam(":id_hospitalizacion", $idHos);
                    $consulta->bindParam(":id_entradaDeInsumo", $idEntradaDeInsumo["id_entradaDeInsumo"]);
                    $consulta->bindParam(":cantidad", $cantidadA[$contadorC]);

                    if ($consulta->execute()) {
                        $consulta2 =  $this->conexion->prepare("CALL DescontarLotes(:i, :cantidad);");
                        $consulta2->bindParam(":i", $idIA);
                        $consulta2->bindParam(":cantidad", $cantidadA[$contadorC]);
                        $consulta2->execute();
                        $consulta2->closeCursor();
                    }

                    $contadorC++;
                }
            }

            // es para eliminar insumos
            // si hay un id del insumo eliminado devuelve verdadero si no, devuelve falso
            if ($idInsElim) {

                $contador = 0;
                foreach ($idInsElim as $idIAEl) {

                    // selecciono la cantidad del insumo existente de la hospitalización
                    $consulta = $this->conexion->prepare('SELECT idh.cantidad, ins.id_insumo FROM insumodehospitalizacion idh INNER JOIN entrada_insumo inv ON idh.id_entradaDeInsumo = inv.id_entradaDeInsumo INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE idh.id_insumoDeHospitalizacion = :id;');
                    $consulta->bindParam(":id", $idIAEl);
                    $cantidadIH = ($consulta->execute()) ? $consulta->fetch() : false;

                    // elimina insumos de la hospitalización
                    $consulta = $this->conexion->prepare('DELETE FROM insumodehospitalizacion WHERE id_insumoDeHospitalizacion = :id_insumo_eliminado');
                    $consulta->bindParam(":id_insumo_eliminado", $idIAEl);
                    // devolver insumos 
                    if ($consulta->execute()) {
                        $consulta2 =  $this->conexion->prepare("CALL devolver_insumo_hospitalizacion(:i, :cantidad);");
                        $consulta2->bindParam(":i", $cantidadIH["id_insumo"]);
                        $consulta2->bindParam(":cantidad", $cantidadIH["cantidad"]);
                        $consulta2->execute();
                        $consulta2->closeCursor();
                    }


                    $contador++;
                }
            }

            // servicios
            $datosSHBD = $this->selectServiciosDH($idHos);

            $servAnterioresIdC = [];
            $idsServAnteriores = [];
            foreach ($datosSHBD as $i => $datos) {
                $id = (int)$datos['id_servicioMedico'];
                // sirve como los ... en php en un array , array vacio
                $idsServAnteriores[$i] = $id;
                $servAnterioresIdC[$id] = (int)$datos['cantidad'];
            }

            // devuelve el valor de el array en int y si no tiene nada devuelve un array vacío
            $idsServNuevos = array_map('intval', $idServicio ?? []);
            $cantServNuevas = $cantidadS ?? [];

            $servIdCNuevas = [];
            // se hace un mapeo, es como un obj con propiedades
            foreach ($idsServNuevos as $contador => $id) {
                // valida si alguno no tiene cantidad
                $servIdCNuevas[$id] = isset($cantServNuevas[$contador]) ? (int)$cantServNuevas[$contador] : 1;
            }
            // trae los elementos que estan en el (primer) array pero no en el (segundo)
            $servEliminados = array_diff($idsServAnteriores, $idsServNuevos);
            $servAgregados  = array_diff($idsServNuevos, $idsServAnteriores);
            // trae los elementos que estan en ambos 
            $servIguales    = array_intersect($idsServNuevos, $idsServAnteriores);

            // Eliminar servicios
            if ($servEliminados != null || $servEliminados != []) {
                foreach ($servEliminados as $idSE) {
                    $consulta = $this->conexion->prepare('DELETE FROM servicios_hospitalizacion WHERE id_hospitalizacion = :id_hospitalizacion AND id_servicioMedico = :id_servicioMedico');
                    $consulta->bindParam(":id_hospitalizacion", $idHos);
                    $consulta->bindParam(":id_servicioMedico", $idSE);
                    $consulta->execute();
                }
            }
            // Insertar servicios
            if ($servAgregados != null || $servAgregados != []) {
                foreach ($servAgregados as $idSA) {
                    $consulta = $this->conexion->prepare('INSERT INTO servicios_hospitalizacion (id_hospitalizacion, id_servicioMedico, cantidad) VALUES (:id_hospitalizacion, :id_servicioMedico, :cantidad)');
                    $consulta->bindValue(":id_hospitalizacion", $idHos);
                    $consulta->bindValue(":id_servicioMedico", $idSA);
                    $consulta->bindValue(":cantidad", $servIdCNuevas[$idSA]);
                    $consulta->execute();
                }
            }


            // Actualizar cantidades de servicios
            if ($servIguales != null || $servIguales != []) {
                foreach ($servIguales as $idS) {
                    $consulta = $this->conexion->prepare('UPDATE servicios_hospitalizacion SET cantidad = :cantidad WHERE id_hospitalizacion = :id_hospitalizacion AND id_servicioMedico = :id_servicioMedico');
                    $consulta->bindValue(":id_hospitalizacion", $idHos);
                    $consulta->bindValue(":id_servicioMedico", $idS);
                    $consulta->bindValue(":cantidad", $servIdCNuevas[$idS]);
                    $consulta->execute();
                }
            }


            // $consulta->bindValue(":cantidad", (int)$servIdCNuevas[$idSA], PDO::PARAM_INT);


            $this->conexion->commit();
            return "exito";
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

                    $consulta2 =  $this->conexion->prepare("CALL devolver_insumo_hospitalizacion(:i, :cantidad);");
                    $consulta2->bindParam(":i", $value["id_insumo"]);
                    $consulta2->bindParam(":cantidad", $value["cantidad"]);
                    $consulta2->execute();
                    $consulta2->closeCursor();
                }
            }

            // editar el estado hospitalización
            $consulta = $this->conexion->prepare('UPDATE hospitalizacion SET estado ="DES" WHERE id_hospitalizacion =:id_h ;');
            $consulta->bindParam(":id_h", $idH);
            $consulta->execute();


            $this->conexion->commit();
            return "exito";
        } catch (\Exception $e) {
            $this->conexion->rollBack();
            print_r($e);
        }
    }


    // buscar insumos de las hospitalizaciones existentes 
    public function buscarIEH()
    {
        $consulta = $this->conexion->prepare("SELECT h.id_hospitalizacion, idh.id_insumoDeHospitalizacion, ins.id_insumo, idh.cantidad, ins.nombre, inv.cantidad_disponible AS cantidadEx, ins.precio, h.fecha_hora_inicio FROM hospitalizacion h INNER JOIN paciente pac ON h.id_paciente = pac.id_paciente INNER JOIN control con ON con.id_paciente = pac.id_paciente INNER JOIN segurity.usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.usuario = u.id_usuario INNER JOIN personal_has_serviciomedico psm ON psm.personal_id_personal = pe.id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico INNER JOIN insumodehospitalizacion idh ON h.id_hospitalizacion = idh.id_hospitalizacion INNER JOIN entrada_insumo inv ON idh.id_entradaDeInsumo = inv.id_entradaDeInsumo INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE con.estado = 'DES' AND sm.estado = 'ACT' AND u.estado = 'ACT' AND ins.estado = 'ACT' AND h.estado = 'Pendiente';");

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function facturarH($idH, $fechaHoraFinal, $monto, $montoME,  $total, $totalME, $historialEnF, $sintomas, $patologias, $nota, $indicaciones, $fechaRegreso, $diagnostico, $severidad)
    {
        try {
            $this->conexion->beginTransaction();

            // editar hospitalización
            $consulta = $this->conexion->prepare("UPDATE hospitalizacion SET precio_horas = :precio_horas ,precio_horas_MoEx = :precio_horas_me ,total= :total ,total_MoEx = :total_me ,fecha_hora_final = :fecha_hora_final WHERE id_hospitalizacion = :id_hospitalizacion");
            $consulta->bindParam(":precio_horas", $monto);
            $consulta->bindParam(":precio_horas_me", $montoME);
            $consulta->bindParam(":total", $total);
            $consulta->bindParam(":total_me", $totalME);
            $consulta->bindParam(":fecha_hora_final", $fechaHoraFinal);
            $consulta->bindParam(":id_hospitalizacion", $idH);
            $consulta->execute();

            $datosControl = $this->datosControl($idH);
            $consulta = $this->conexion->prepare('UPDATE control SET medicamentosRecetados = :indicaciones, historiaclinica = :historial, diagnostico = :diagnostico, fechaRegreso = :fechaRegreso, nota = :nota, estado = "ACT", severidad = :severidad WHERE id_control = :id_control;');
            $consulta->bindParam(":indicaciones", $indicaciones);
            $consulta->bindParam(":historial", $historialEnF);
            $consulta->bindParam(":diagnostico", $diagnostico);
            $consulta->bindParam(":fechaRegreso", $fechaRegreso);
            $consulta->bindParam(":nota", $nota);
            $consulta->bindParam(":severidad", $severidad);
            $consulta->bindParam(":id_control", $datosControl["id_control"]);
            $consulta->execute();


            if ($patologias) {

                // primero se registra la patologia del paciente
                foreach ($patologias as $patologia) {
                    $consulta2 = $this->conexion->prepare("INSERT INTO patologiadepaciente(id_paciente, id_patologia, fecha_registro) VALUES (:id_paciente, :id_patologia, NOW())");
                    $consulta2->bindParam(":id_paciente", $datosControl["id_paciente"]);
                    $consulta2->bindParam(":id_patologia", $patologia);
                    $consulta2->execute();
                }
            }
            // agrega el síntoma 
            foreach ($sintomas as $sintoma) {
                $sql = $this->conexion->prepare("INSERT INTO sintomas_control(id_sintomas, id_control) VALUES (:sintoma,:idControl);");
                $sql->bindParam(":sintoma", $sintoma);
                $sql->bindParam(":idControl", $datosControl["id_control"]);
                $sql->execute();
            }

            $this->conexion->commit();
            return "exito";
        } catch (\Exception $e) {
            $this->conexion->rollBack();
            print_r($e);
        }
    }
    public function semaforo()
    {
        try {

            // verifica cuantas hospitalizaciones hay pendiente
            $consulta = $this->conexion->prepare("SELECT COUNT(*) FROM hospitalizacion WHERE estado = 'Pendiente';");

            return ($consulta->execute()) ? $consulta->fetch() : false;
        } catch (\Exception $e) {
            print_r("ocurrio un error en hospitalización, intente mas tarde");
        }
    }
}
