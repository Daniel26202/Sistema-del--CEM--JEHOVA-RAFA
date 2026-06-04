<?php

namespace App\modelos;

use App\modelos\ModelBase;
use Exception;

class ModeloHospitalizacion extends ModelBase
{

    private $idH, $fechaHora, $idInsumo, $nombreInsumo, $cantidadIns, $idServicio, $fechaControl, $idInsH, $idInsElim, $idInsumosA, $cantidadE, $cantidadA, $fechaHoraFinal, $monto, $montoME, $total, $totalME, $patologiasId, $sintomasId, $cantidadSer, $severidad, $nota, $fechaRegreso, $diagnostico, $historial, $indicaciones, $cedula, $id_paciente, $id_doctor;

    public function __construct($dbSystem = true)
    {
        parent::__construct($dbSystem);
    }

    public function index()
    {
        try {
            $sql = "SELECT * FROM paciente WHERE estado = 'ACT'";
            $this->setSQL($sql);
            $consulta = $this->read();
            return !empty($consulta) ? $consulta : false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    //     public function selectsH()
    // {
    //     try {
    //         $sql = "SELECT h.id_hospitalizacion, h.fecha_hora_inicio, h.precio_horas, h.fecha_hora_final, h.total, con.id_control, con.diagnostico, con.historiaclinica, pac.id_paciente, pac.nacionalidad, pac.cedula, pac.nombre, pac.apellido, u.id_usuario, pe.nombre AS nombredoc, pe.apellido AS apellidodoc FROM hospitalizacion h INNER JOIN paciente pac ON h.id_paciente = pac.id_paciente INNER JOIN control con ON con.id_control = (
    //                     SELECT con2.id_control FROM control con2 
    //                     WHERE con2.id_paciente = pac.id_paciente 
    //                     AND con2.estado = 'DES' 
    //                     ORDER BY con2.id_control DESC LIMIT 1
    //                 ) 
    //                 INNER JOIN segurity.usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.usuario = u.id_usuario WHERE u.estado = 'ACT' AND h.estado = 'Pendiente' GROUP BY h.id_hospitalizacion;";

    //         $this->setSQL($sql);
    //         $consulta = $this->read();
    //         return !empty($consulta) ? $consulta : false;
    //     } catch (\Exception $e) {
    //         return $e->getMessage();
    //     }
    // }


    public function mostrarHospitalizacionesApk()
    {
        try {
            $sql = "SELECT h.id_hospitalizacion, h.fecha_hora_inicio, h.estado AS estado_h, p.id_paciente, p.nombre   AS nombre_p, p.apellido AS apellido_p, p.cedula, TIMESTAMPDIFF(YEAR, p.fn, CURDATE()) AS edad, pe.nombre   AS nombre_d, pe.apellido AS apellido_d, con.diagnostico, con.historiaclinica,con.severidad
                FROM hospitalizacion h
                INNER JOIN paciente p  ON p.id_paciente   = h.id_paciente
                INNER JOIN personal pe ON pe.id_personal  = h.personal_id_personal
                LEFT JOIN control con ON con.id_control = ( 
                    SELECT con2.id_control FROM control con2
                    WHERE con2.id_paciente = p.id_paciente AND con2.estado = 'DES' 
                    ORDER BY con2.id_control DESC
                    LIMIT 1
                )
                WHERE h.estado = 'Pendiente' ORDER BY h.fecha_hora_inicio ASC";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function contarAltasHoy($fecha)
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM hospitalizacion WHERE estado = 'Realizada' AND DATE(fecha_hora_final) = :fecha";
            $this->setSQL($sql);
            $result = $this->search(['fecha' => $fecha], false);
            return (int)($result['total'] ?? 0);
        } catch (\Exception $e) {
            return 0;
        }
    }



    // selecciono 6 tablas de la base de datos con el INNER JOIN, uso solo los datos que necesito, para mostrarlo en la tabla de la vista (de las hospitalizaciones pendientes)
    public function selectsH()
    {
        try {
            $sql = "SELECT * FROM view_paciente_hospitalizado WHERE estado_servicio= 'ACT'  AND estado_usuario = 'ACT' AND estado_hospitalizacion = 'Pendiente' GROUP BY id_hospitalizacion";

            $this->setSQL($sql);
            $consulta = $this->read();
            return !empty($consulta) ? $consulta : false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function selectDoctores()
    {
        try {
            $sql = "SELECT DISTINCT p.nombre, p.apellido, p.id_personal FROM personal p JOIN personal_has_serviciomedico phs ON phs.personal_id_personal = p.id_personal JOIN horarioydoctor hd ON hd.id_personal = p.id_personal JOIN horario h ON h.id_horario = hd.id_horario JOIN serviciomedico sm ON sm.id_servicioMedico = phs.serviciomedico_id_servicioMedico WHERE sm.estado = 'ACT' 
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
        );";

            $this->setSQL($sql);
            $consulta = $this->read();
            return !empty($consulta) ? $consulta : false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function selectServiciosDH()
    {
        try {

            $sql = "SELECT * FROM servicios_hospitalizacion WHERE id_hospitalizacion = :id_hospitalizacion;";
            $this->setSQL($sql);

            $consulta = $this->search(['id_hospitalizacion' => $this->getIdH()], true);

            return !empty($consulta) ? $consulta : false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }




    public function selectServiciosD()
    {
        try {
            $sql = "SELECT DISTINCT sm.tipo, sm.precio, cs.nombre AS categoria, p.nombre, p.apellido, sm.id_servicioMedico, sm.tipo FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria INNER JOIN personal_has_serviciomedico phs ON phs.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN personal p ON p.id_personal = phs.personal_id_personal INNER JOIN horarioydoctor hd ON hd.id_personal = p.id_personal INNER JOIN horario h ON h.id_horario = hd.id_horario WHERE sm.estado = 'ACT'
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
            );";

            $this->setSQL($sql);
            $consulta = $this->read();
            return !empty($consulta) ? $consulta : false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // selecciono 6 tablas de la base de datos con el INNER JOIN, uso solo los datos que necesito, para mostrarlo en la tabla de la vista (de las hospitalizaciones realizadas)
    public function selectsHR()
    {
        try {
            $sql = "SELECT * FROM view_paciente_hospitalizado WHERE estado_hospitalizacion = 'Realizada' GROUP BY id_hospitalizacion";

            $this->setSQL($sql);
            $consulta = $this->read();
            return !empty($consulta) ? $consulta : false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }




    // validamos si el paciente existe
    public function validarPacienteH()
    {
        try {

            $sql = "SELECT cedula, id_paciente, nombre, apellido FROM paciente WHERE cedula = :cedula AND estado= 'ACT'";
            $this->setSQL($sql);

            $consulta = $this->search(['cedula' => $this->getCedula()], false);

            return !empty($consulta) ? $consulta : false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // selecciono 6 tablas de la base de datos con el INNER JOIN, uso solo los datos que necesito.
    // selecciono el control de un paciente.
    public function select()
    {
        try {

            $sql = "SELECT con.id_control, con.historiaclinica, con.diagnostico, pac.id_paciente, pac.cedula, pac.nombre, pac.apellido, u.id_usuario, pe.nombre AS nombredoc, pe.apellido AS apellidodoc FROM control con INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN segurity.usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.usuario = u.id_usuario INNER JOIN personal_has_serviciomedico psm ON psm.personal_id_personal = pe.id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico WHERE pac.cedula = :cedula AND con.estado = 'ACT' AND sm.estado = 'ACT' AND u.estado = 'ACT' ORDER by con.id_control DESC LIMIT 1";
            $this->setSQL($sql);

            $consulta = $this->search(['cedula' => $this->getCedula()], false);

            return !empty($consulta) ? $consulta : false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // selecciono todos los insumos
    public function selectsInsumos()
    {
        try {
            $sql = "SELECT ins.*, sum(inv.cantidad_disponible) AS cantidad FROM insumo ins INNER JOIN entrada_insumo inv ON inv.id_insumo = ins.id_insumo WHERE estado = 'ACT' AND inv.cantidad_disponible > 0 GROUP BY inv.id_insumo";

            $this->setSQL($sql);
            $consulta = $this->read();
            return !empty($consulta) ? $consulta : false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    // buscar insumos por nombre
    public function buscarInsumos()
    {
        try {

            $sql = "SELECT ins.*, en_in.* FROM insumo ins INNER JOIN entrada_insumo en_in ON en_in.id_insumo = ins.id_insumo WHERE ins.estado = 'ACT' AND en_in.cantidad_disponible > 0 AND ins.nombre LIKE :nombre;";
            $this->setSQL($sql);

            $consulta = $this->search(['nombre' => "%" . $this->getNombreInsumo() . "%"], true);

            return !empty($consulta) ? $consulta : false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function buscarUnInsumo()
    {
        try {

            $sql = "SELECT ins.id_insumo, inv.id_entradaDeInsumo, ins.nombre, ins.precio, sum(inv.cantidad_disponible) AS limite_insumo FROM insumo ins INNER JOIN entrada_insumo inv ON inv.id_insumo = ins.id_insumo INNER JOIN entrada e ON e.id_entrada = inv.id_entrada  WHERE ins.estado = 'ACT' AND ins.id_insumo =:id ORDER BY e.fechaDeIngreso";
            $this->setSQL($sql);

            $idInsumo = $this->getIdInsumo();
            $id = is_array($idInsumo) ? $idInsumo[0] : $idInsumo;
            $consulta = $this->search(['id' => $id], false);

            return !empty($consulta) ? $consulta : false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // verifica si la hospitalización existe
    public function verificaHA()
    {
        try {

            $sql = "SELECT id_hospitalizacion FROM hospitalizacion WHERE id_paciente = :id_paciente AND personal_id_personal = :id_personal AND estado = 'Pendiente';";
            $this->setSQL($sql);
            $data = [
                'id_paciente' => $this->getIdPaciente(),
                'id_personal' => $this->getIdDoctor()
            ];
            $consulta = $this->search($data, false);

            return !empty($consulta) ? true : false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function insertarH()
    {

        try {
            $this->beginTransaction();

            $dataH = [
                'fecha_hora_inicio' => $this->getFechaHora(),
                'id_paciente' => $this->getIdPaciente(),
                'id_personal' => $this->getIdDoctor()
            ];

            $sql = "INSERT INTO hospitalizacion (fecha_hora_inicio, precio_horas, precio_horas_MoEx, total, total_MoEx, id_paciente, fecha_hora_final, estado, personal_id_personal)  VALUES (:fecha_hora_inicio, '', '', '', '', :id_paciente, '', 'Pendiente', :id_personal);";
            $this->setSQL($sql);
            //devuelve el id de la hospitalización.
            $idH = $this->create($dataH);
            $idHospitalizacion = $idH;
            $idInsumos = $this->getIdInsumo();
            // si hay un id del insumo devuelve verdadero si no, devuelve falso
            if ($idInsumos) {

                $cantidad = $this->getCantidadIns();
                $contadorC = 0;

                foreach ($idInsumos as $idI) {

                    $sql = "SELECT inv.id_entradaDeInsumo FROM entrada_insumo inv INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo INNER JOIN entrada e ON e.id_entrada= inv.id_entrada WHERE inv.id_insumo =:id_insumo AND inv.cantidad_disponible >= :cantidad ORDER BY e.fechaDeIngreso LIMIT 1;";
                    $this->setSQL($sql);
                    $data = [
                        'id_insumo' => $idI,
                        'cantidad' => $cantidad[$contadorC]
                    ];
                    $consulta = $this->search($data, false);
                    // selecciono id de entrada_insumo
                    $idEntradaDeInsumo = !empty($consulta) ? $consulta : false;


                    // insertar insumos de la hospitalización
                    $sql = "INSERT INTO insumodehospitalizacion(id_hospitalizacion, id_entradaDeInsumo, cantidad) VALUES (:id_hospitalizacion, :id_entradaDeInsumo, :cantidad)";
                    $this->setSQL($sql);
                    $data = [
                        'id_hospitalizacion' => $idHospitalizacion,
                        'id_entradaDeInsumo' => $idEntradaDeInsumo["id_entradaDeInsumo"],
                        'cantidad' => $cantidad[$contadorC]
                    ];
                    //devuelve el id de la hospitalización.
                    $idH = $this->create($data);


                    // descontar del lote
                    $sql = "CALL DescontarLotes(:i, :cantidad);";
                    $this->setSQL($sql);
                    $data = [
                        'i' => $idI,
                        'cantidad' => $cantidad[$contadorC]
                    ];
                    $this->storedProcedure($data);

                    $contadorC++;
                }
            }

            $idServicio = $this->getIdServicio();
            // si hay un id del servicio devuelve verdadero si no, devuelve falso
            if ($idServicio) {

                $cantidadS =  $this->getCantidadSer();
                $contador = 0;
                foreach ($idServicio as $idS) {

                    // insertar servicio de la hospitalización
                    $sql = "INSERT INTO servicios_hospitalizacion(id_hospitalizacion, id_servicioMedico, cantidad) VALUES (:id_hospitalizacion, :id_servicioMedico, :cantidad)";
                    $this->setSQL($sql);
                    $data = [
                        'id_hospitalizacion' => $idHospitalizacion,
                        'id_servicioMedico' => $idS,
                        'cantidad' => $cantidadS[$contador]
                    ];
                    //devuelve el id de la hospitalización.
                    $this->create($data);

                    $contador++;
                }
            }

            // seleccionamos el id del
            $sql = "SELECT u.id_usuario FROM segurity.usuario u JOIN bd.personal p ON p.usuario = u.id_usuario WHERE p.id_personal = :id_personal LIMIT 1;";
            $this->setSQL($sql);
            $data = [
                'id_personal' => $this->getIdDoctor()
            ];
            $consulta = $this->search($data, false);

            $idUsuario = !empty($consulta) ? $consulta : false;

            // insertar control
            $sql = "INSERT INTO control (id_paciente, id_usuario, diagnostico, medicamentosRecetados, fecha_control, fechaRegreso, nota, historiaclinica, estado, severidad) VALUES (:id_paciente, :id_usuario, :diagnostico, '', :fecha_control, '', '', :historial, 'DES', :severidad);";
            $this->setSQL($sql);
            $data = [
                'id_paciente' => $this->getIdPaciente(),
                'id_usuario' => $idUsuario["id_usuario"],
                'diagnostico' => $this->getDiagnostico(),
                'fecha_control' => $this->getFechaControl(),
                'historial' => $this->getHistorial(),
                'severidad' => $this->getSeveridad(),
            ];
            //devuelve el id de la hospitalización.
            $this->create($data);


            $sql = "SELECT * from hospitalizacion where id_hospitalizacion=:id_hospitalizacion";
            $this->setSQL($sql);
            $data = $this->search(['id_hospitalizacion' => $idHospitalizacion], false);

            $this->commit();
            return ["exito", $data];
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }


    // traer insumos por el id de la hospitalización
    public function EInsumosM()
    {

        $sql = "SELECT h.id_hospitalizacion, idh.id_insumoDeHospitalizacion, ins.id_insumo, idh.cantidad, ins.nombre, ins.precio, h.fecha_hora_inicio, inv.cantidad_disponible AS limite_insumo FROM hospitalizacion h INNER JOIN paciente pac ON h.id_paciente = pac.id_paciente INNER JOIN control con ON con.id_paciente = pac.id_paciente INNER JOIN segurity.usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.usuario = u.id_usuario INNER JOIN personal_has_serviciomedico psm ON psm.personal_id_personal = pe.id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico INNER JOIN insumodehospitalizacion idh ON h.id_hospitalizacion = idh.id_hospitalizacion INNER JOIN entrada_insumo inv ON idh.id_entradaDeInsumo = inv.id_entradaDeInsumo INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE con.estado = 'DES' AND u.estado = 'ACT' AND ins.estado = 'ACT' AND h.id_hospitalizacion = :id GROUP BY ins.id_insumo;";
        $this->setSQL($sql);
        $data = [
            'id' => $this->getIdH(),
        ];
        return $this->search($data, true);
    }

    public function datosControl()
    {
        // consulta el id del control
        $sql = "SELECT con.id_control, con.id_paciente FROM control con INNER JOIN hospitalizacion h ON h.id_paciente = con.id_paciente WHERE h.id_hospitalizacion = :idHosp ORDER by con.id_control DESC LIMIT 1;";
        $this->setSQL($sql);
        $data = [
            'idHosp' => $this->getIdH(),
        ];
        return $this->search($data, false);
    }


    public function editarH()
    {
        try {
            $this->beginTransaction();
            // consulta el id del control
            $sql = "SELECT * from hospitalizacion where id_hospitalizacion=:id_hospitalizacion";
            $this->setSQL($sql);
            $data = [
                'id_hospitalizacion' => $this->getIdH(),
            ];
            $validar = $this->search($data, false);
            if ($validar == []) {
                throw new \Exception("Fallo");
            }
            // consulta el id del control
            $idControl = $this->datosControl();


            // editar control
            $sql = "UPDATE control SET historiaclinica = :historial, diagnostico = :diagnostico WHERE id_control = :id ;";
            $this->setSQL($sql);
            $data = [
                "historial" => $this->getHistorial(),
                "diagnostico" => $this->getDiagnostico(),
            ];

            $this->update($data, $idControl["id_control"]);

            // es para a editar insumos
            // si hay un id del insumo de hospitalización devuelve verdadero si no, devuelve falso
            $cantidadE = $this->getCantidadE();
            $idIDH = $this->getIdInsH();
            if ($idIDH) {

                $contador = 0;

                foreach ($idIDH as $idInDHos) {

                    // selecciono la cantidad del insumo existente de la hospitalización
                    $sql = 'SELECT idh.cantidad, ins.id_insumo FROM insumodehospitalizacion idh INNER JOIN entrada_insumo inv ON idh.id_entradaDeInsumo = inv.id_entradaDeInsumo INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE id_insumoDeHospitalizacion = :id';
                    $this->setSQL($sql);
                    $cantidadIHBD = $this->search(['id' => $idInDHos], false);

                    // se edita los insumos de la hospitalización
                    $sql = 'UPDATE insumodehospitalizacion SET cantidad= :cantidad WHERE id_insumoDeHospitalizacion = :id';
                    $this->setSQL($sql);
                    $this->update(['cantidad' => $cantidadE[$contador]], $idInDHos);

                    // se resta al inventario (suma a los insumos de hospitalización)
                    if ($cantidadE[$contador] > $cantidadIHBD["cantidad"]) {

                        $cS = $cantidadE[$contador] - $cantidadIHBD["cantidad"];

                        $sql =  "CALL DescontarLotes(:i, :cantidad);";
                        $this->setSQL($sql);
                        $this->storedProcedure(['i' => $cantidadIHBD["id_insumo"], 'cantidad' => $cS]);

                        // se suma al inventario (resta a los insumos de hospitalización)
                    } else if ($cantidadE[$contador] < $cantidadIHBD["cantidad"]) {

                        $cR = $cantidadIHBD["cantidad"] - $cantidadE[$contador];
                        $sql = "CALL devolver_insumos_hospitalizacion(:i, :cantidad);";
                        $this->setSQL($sql);
                        $this->storedProcedure(['i' => $cantidadIHBD["id_insumo"], 'cantidad' => $cR]);
                    }

                    $contador++;
                }
            }

            // es para agregar insumos
            // si hay un id del insumo devuelve verdadero si no, devuelve falso
            $idInsumosA = $this->getIdInsumosA();
            $cantidadA = $this->getCantidadA();
            if ($idInsumosA) {

                $contadorC = 0;

                foreach ($idInsumosA as $idIA) {

                    // selecciono id de entrada_insumo
                    $sql = 'SELECT inv.id_entradaDeInsumo FROM entrada_insumo inv INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo INNER JOIN entrada e ON e.id_entrada= inv.id_entrada WHERE inv.id_insumo =:id_insumo AND inv.cantidad_disponible >= :cantidad ORDER BY e.fechaDeIngreso LIMIT 1;';
                    $this->setSQL($sql);
                    $idEntradaDeInsumo = $this->search(['id_insumo' => $idIA, 'cantidad' => $cantidadA[$contadorC]], false);

                    if (!$idEntradaDeInsumo || empty($idEntradaDeInsumo["id_entradaDeInsumo"])) {
                        throw new \Exception("No hay suficiente stock disponible para el insumo ID: $idIA. Cantidad solicitada: {$cantidadA[$contadorC]}");
                    }

                    // insertar insumos de la hospitalización
                    $sql = 'INSERT INTO insumodehospitalizacion(id_hospitalizacion, id_entradaDeInsumo, cantidad) VALUES (:id_hospitalizacion, :id_entradaDeInsumo, :cantidad)';
                    $this->setSQL($sql);
                    $data = [
                        'id_hospitalizacion' => $this->getIdH(),
                        'id_entradaDeInsumo' => $idEntradaDeInsumo["id_entradaDeInsumo"],
                        'cantidad' => $cantidadA[$contadorC]
                    ];
                    $insertado = $this->create($data);

                    if ($insertado) {
                        $sql =  "CALL DescontarLotes(:i, :cantidad);";
                        $this->setSQL($sql);
                        $this->storedProcedure(['i' => $idIA, 'cantidad' => $cantidadA[$contadorC]]);
                    }

                    $contadorC++;
                }
            }

            // es para eliminar insumos
            // si hay un id del insumo eliminado devuelve verdadero si no, devuelve falso
            $idInsElim = $this->getIdInsElim();
            if ($idInsElim) {

                $contador = 0;
                foreach ($idInsElim as $idIAEl) {

                    // selecciono la cantidad del insumo existente de la hospitalización
                    $consulta = 'SELECT idh.cantidad, ins.id_insumo FROM insumodehospitalizacion idh INNER JOIN entrada_insumo inv ON idh.id_entradaDeInsumo = inv.id_entradaDeInsumo INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE idh.id_insumoDeHospitalizacion = :id;';
                    $this->setSQL($consulta);
                    $cantidadIH = $this->search(['id' => $idIAEl], false);

                    // elimina insumos de la hospitalización
                    $sql = 'DELETE FROM insumodehospitalizacion WHERE id_insumoDeHospitalizacion = :id_insumo_eliminado';
                    $this->setSQL($sql);
                    $validar = $this->delete(['id_insumo_eliminado' => $idIAEl]);
                    // devolver insumos 
                    if ($validar) {
                        $sql =  "CALL devolver_insumos_hospitalizacion(:i, :cantidad);";
                        $this->setSQL($sql);
                        $this->storedProcedure([
                            'i' => $cantidadIH["id_insumo"],
                            'cantidad' => $cantidadIH["cantidad"]
                        ]);
                    }

                    $contador++;
                }
            }

            // servicios
            $datosSHBD = $this->selectServiciosDH($this->getIdH());
            if (!$datosSHBD) {
                $datosSHBD = [];
            }
            $servAnterioresIdC = [];
            $idsServAnteriores = [];
            foreach ($datosSHBD as $i => $datos) {
                $id = (int)$datos['id_servicioMedico'];
                // sirve como los ... en php en un array , array vacio
                $idsServAnteriores[$i] = $id;
                $servAnterioresIdC[$id] = (int)$datos['cantidad'];
            }
            $idServicio = $this->getIdServicio();
            $cantidadS = $this->getCantidadSer();
            // devuelve el valor del array en int y si no tiene nada devuelve un array vacío
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

                    $sql = 'DELETE FROM servicios_hospitalizacion WHERE id_hospitalizacion = :id_hospitalizacion AND id_servicioMedico = :id_servicioMedico';
                    $this->setSQL($sql);
                    $this->delete([
                        'id_hospitalizacion' => $this->getIdH(),
                        'id_servicioMedico' => $idSE
                    ]);
                }
            }
            // Insertar servicios
            if ($servAgregados != null || $servAgregados != []) {
                foreach ($servAgregados as $idSA) {
                    $sql = 'INSERT INTO servicios_hospitalizacion (id_hospitalizacion, id_servicioMedico, cantidad) VALUES (:id_hospitalizacion, :id_servicioMedico, :cantidad)';
                    $this->setSQL($sql);
                    $this->create([
                        'id_hospitalizacion' => $this->getIdH(),
                        'id_servicioMedico' => $idSA,
                        'cantidad' => $servIdCNuevas[$idSA]
                    ]);
                }
            }


            // Actualizar cantidades de servicios
            if ($servIguales != null || $servIguales != []) {
                foreach ($servIguales as $idS) {
                    $sql = 'UPDATE servicios_hospitalizacion SET cantidad = :cantidad WHERE id_hospitalizacion = :id AND id_servicioMedico = :id';
                    $this->setSQL($sql);
                    $this->update([
                        'id_servicioMedico' => $idS,
                        'cantidad' => $servIdCNuevas[$idS]
                    ], $this->getIdH());
                }
            }


            // $consulta->bindValue(":cantidad", (int)$servIdCNuevas[$idSA], PDO::PARAM_INT);


            $this->commit();
            return ["exito"];
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }

    // eliminación lógica
    public function eliminaLogico()
    {
        try {
            $this->beginTransaction();

            $sql = "SELECT * from hospitalizacion where id_hospitalizacion=:id_hospitalizacion";
            $this->setSQL($sql);
            $validar = $this->search(['id_hospitalizacion' => $this->getIdH()], false);
            if ($validar == []) {
                throw new \Exception("Fallo");
            }
            $datosIDH = $this->EInsumosM();
            // // si hay un id del insumo devuelve verdadero si no, devuelve falso
            if ($datosIDH) {

                foreach ($datosIDH as $indice => $value) {

                    $sql = "CALL devolver_insumos_hospitalizacion(:i, :cantidad);";
                    $this->setSQL($sql);
                    $this->storedProcedure([
                        'i' => $value["id_insumo"],
                        'cantidad' => $value["cantidad"]
                    ]);
                    // $consulta2->closeCursor();
                }
            }

            // editar el estado hospitalización
            $sql = 'UPDATE hospitalizacion SET estado ="DES" WHERE id_hospitalizacion =:id ;';
            $this->setSQL($sql);
            $this->update([], $this->getIdH());

            $this->commit();
            return ["exito"];
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }


    // buscar insumos de las hospitalizaciones existentes 
    public function buscarIEH()
    {
        $sql = "SELECT h.id_hospitalizacion, idh.id_insumoDeHospitalizacion, ins.id_insumo, idh.cantidad, ins.nombre, inv.cantidad_disponible AS cantidadEx, ins.precio, h.fecha_hora_inicio FROM hospitalizacion h INNER JOIN paciente pac ON h.id_paciente = pac.id_paciente INNER JOIN control con ON con.id_paciente = pac.id_paciente INNER JOIN segurity.usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.usuario = u.id_usuario INNER JOIN personal_has_serviciomedico psm ON psm.personal_id_personal = pe.id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico INNER JOIN insumodehospitalizacion idh ON h.id_hospitalizacion = idh.id_hospitalizacion INNER JOIN entrada_insumo inv ON idh.id_entradaDeInsumo = inv.id_entradaDeInsumo INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE con.estado = 'DES' AND sm.estado = 'ACT' AND u.estado = 'ACT' AND ins.estado = 'ACT' AND h.estado = 'Pendiente';";

        $this->setSQL($sql);
        return $this->read();
    }

    public function facturarH()
    {
        try {
            $this->beginTransaction();

            // editar hospitalización
            $sql = "UPDATE hospitalizacion SET precio_horas = :precio_horas ,precio_horas_MoEx = :precio_horas_me ,total= :total ,total_MoEx = :total_me ,fecha_hora_final = :fecha_hora_final WHERE id_hospitalizacion = :id";
            $this->setSQL($sql);
            $data = [
                'precio_horas' => $this->getMonto(),
                'precio_horas_me' => $this->getMontoME(),
                'total' => $this->getTotal(),
                'total_me' => $this->getTotalME(),
                'fecha_hora_final' => $this->getFechaHoraFinal(),
            ];
            $this->update($data, $this->getIdH());

            $datosControl = $this->datosControl();

            $sql = 'UPDATE control SET medicamentosRecetados = :indicaciones, historiaclinica = :historial, diagnostico = :diagnostico, fechaRegreso = :fechaRegreso, nota = :nota, severidad = :severidad WHERE id_control = :id;';
            $this->setSQL($sql);
            $data = [
                "indicaciones" => $this->getIndicaciones(),
                "historial" => $this->getHistorial(),
                "diagnostico" => $this->getDiagnostico(),
                "fechaRegreso" => $this->getFechaDeRegreso(),
                "nota" => $this->getNota(),
                "severidad" => $this->getSeveridad(),
            ];
            $this->update($data, $datosControl["id_control"]);

            $patologias = $this->getPatologiasId();
            if ($patologias) {

                // primero se registra la patologia del paciente
                foreach ($patologias as $patologia) {

                    $sql = "INSERT INTO patologiadepaciente(id_paciente, id_patologia, fecha_registro) VALUES (:id_paciente, :id_patologia, NOW())";
                    $this->setSQL($sql);
                    $data = [
                        'id_paciente' => $datosControl["id_paciente"],
                        'id_patologia' => $patologia
                    ];
                    $this->create($data);
                }
            }
            // agrega el síntoma 
            $sintomas = $this->getSintomasId();
            foreach ($sintomas as $sintoma) {
                $sql = "INSERT INTO sintomas_control(id_sintomas, id_control) VALUES (:sintoma,:idControl);";
                $this->setSQL($sql);
                $data = [
                    "sintoma" => $sintoma,
                    "idControl" => $datosControl["id_control"]
                ];
                $this->create($data);
            }

            $this->commit();
            return "exito";
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }
    public function semaforo()
    {
        try {

            // verifica cuantas hospitalizaciones hay pendiente
            $sql = "SELECT COUNT(*) as cantidadP FROM hospitalizacion WHERE estado = 'Pendiente';";
            $this->setSQL($sql);
            $consulta = $this->read();

            return $consulta;
        } catch (\Exception $e) {
            print_r("ocurrio un error en hospitalización, intente mas tarde");
        }
    }


    // getter y setter.............
    // setter
    public function setIdH($idH)
    {
        if (!preg_match('/^[0-9]+$/', $idH)) {
            throw new \InvalidArgumentException('El ID no es válido.');
        }
        if ((int)$idH <= 0) {
            throw new \InvalidArgumentException('El ID debe ser mayor que cero.');
        }
        $this->idH = (int)$idH;
    }

    public function setIdInsumosA($idInsumosA)
    {
        // no hay id seleccionado
        if (empty($idInsumosA)) {
            $this->idInsumosA = null;
            return;
        }
        foreach ($idInsumosA as $id) {
            if (!preg_match('/^[0-9]+$/', $id)) {
                throw new \InvalidArgumentException('El ID no es válido.');
            }
            if ((int)$id <= 0) {
                throw new \InvalidArgumentException('El ID debe ser mayor que cero.');
            }
        }
        $this->idInsumosA = $idInsumosA;
    }

    public function setIdInsumo($idInsumo)
    {
        if (empty($idInsumo)) {
            $this->idInsumo = null;
            return;
        }
        // Si viene como string/int, convertir a array
        if (!is_array($idInsumo)) {
            $idInsumo = [$idInsumo];
        }
        foreach ($idInsumo as $id) {
            if (!preg_match('/^[0-9]+$/', $id)) {
                throw new \InvalidArgumentException('El ID del insumo no es válido.');
            }
            if ((int)$id <= 0) {
                throw new \InvalidArgumentException('El ID del insumo debe ser mayor que cero.');
            }
        }
        $this->idInsumo = $idInsumo;
    }

    public function setIdServicio($idServicio)
    {
        // no hay id seleccionado
        if (empty($idServicio)) {
            $this->idServicio = null;
            return;
        }

        foreach ($idServicio as $id) {
            if (!preg_match('/^[0-9]+$/', $id)) {
                throw new \InvalidArgumentException('El ID del servicio no es válido.');
            }
            if ((int)$id <= 0) {
                throw new \InvalidArgumentException('El ID del servicio debe ser mayor que cero.');
            }
        }
        $this->idServicio = $idServicio;
    }

    public function setNombreInsumo($nombreInsumo)
    {
        if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s\-\%]{3,50}$/", $nombreInsumo)) {
            throw new \InvalidArgumentException("El nombre del insumo no es válido.");
        }

        $this->nombreInsumo = $nombreInsumo;
    }

    public function setFechaHora($fechaHora)
    {
        // $d = new \DateTime($fechaHora);
        // $hoy = new \DateTime();
        // if ($d > $hoy) {
        //     throw new \InvalidArgumentException("La fecha no puede ser futura");
        // }
        $this->fechaHora = $fechaHora;
    }
    public function setFechaHoraFinal($fechaHoraFinal)
    {
        // $d = new \DateTime($fechaHoraFinal);
        // $hoy = new \DateTime();
        // if ($d > $hoy) {
        //     throw new \InvalidArgumentException("La fecha no puede ser futura");
        // }
        $this->fechaHoraFinal = $fechaHoraFinal;
    }

    public function setCantidadIns($cantidadIns)
    {
        if (empty($cantidadIns)) {
            $this->cantidadIns = null;
            return;
        }
        foreach ($cantidadIns as $cantidad) {
            if (!preg_match('/^[0-9]+$/', $cantidad)) {
                throw new \InvalidArgumentException('La cantidad no es válida.');
            }
            if ((int)$cantidad <= 0) {
                throw new \InvalidArgumentException('La cantidad debe ser mayor que cero.');
            }
        }
        $this->cantidadIns = $cantidadIns;
    }

    public function setCantidadSer($cantidadSer)
    {
        if (empty($cantidadSer)) {
            $this->cantidadSer = null;
            return;
        }
        foreach ($cantidadSer as $cantidad) {
            if (!preg_match('/^[0-9]+$/', $cantidad)) {
                throw new \InvalidArgumentException('La cantidad no es válida.');
            }
            if ((int)$cantidad <= 0) {
                throw new \InvalidArgumentException('La cantidad debe ser mayor que cero.');
            }
        }
        $this->cantidadSer = $cantidadSer;
    }

    public function setIdInsH($idInsH)
    {
        // no hay insumo seleccionado
        if (empty($idInsH)) {
            $this->idInsH = null;
            return;
        }
        foreach ($idInsH as $id) {
            if (!preg_match('/^[0-9]+$/', $id)) {
                throw new \InvalidArgumentException('El ID no es válido.');
            }
            if ((int)$id <= 0) {
                throw new \InvalidArgumentException('El ID debe ser mayor que cero.');
            }
        }
        $this->idInsH = $idInsH;
    }

    public function setIdInsElim($idInsElim)
    {
        // no hay id seleccionado
        if (empty($idInsElim)) {
            $this->idInsElim = null;
            return;
        }
        foreach ($idInsElim as $id) {
            if (!preg_match('/^[0-9]+$/', $id)) {
                throw new \InvalidArgumentException('El ID no es válido.');
            }
            if ((int)$id <= 0) {
                throw new \InvalidArgumentException('El ID debe ser mayor que cero.');
            }
        }
        $this->idInsElim = $idInsElim;
    }

    public function setCantidadE($cantidadE)
    {
        // no hay id seleccionado
        if (empty($cantidadE)) {
            $this->cantidadE = null;
            return;
        }
        foreach ($cantidadE as $cantidad) {
            if (!preg_match('/^[0-9]+$/', $cantidad)) {
                throw new \InvalidArgumentException('La cantidad no es válida.');
            }
            if ((int)$cantidad <= 0) {
                throw new \InvalidArgumentException('La cantidad debe ser mayor que cero.');
            }
        }
        $this->cantidadE = $cantidadE;
    }

    public function setCantidadA($cantidadA)
    {
        // no hay cantidad seleccionada
        if (empty($cantidadA)) {
            $this->cantidadA = null;
            return;
        }
        foreach ($cantidadA as $cantidad) {
            if (!preg_match('/^[0-9]+$/', $cantidad)) {
                throw new \InvalidArgumentException('La cantidad no es válida.');
            }
            if ((int)$cantidad <= 0) {
                throw new \InvalidArgumentException('La cantidad debe ser mayor que cero.');
            }
        }
        $this->cantidadA = $cantidadA;
    }

    public function setFechaControl($fechaControl)
    {
        $this->fechaControl = $fechaControl;
    }

    public function setMonto($monto)
    {
        if (!preg_match('/^(?!0$)(?!1$)\d+([.,]\d+)?$/', $monto)) {
            throw new \InvalidArgumentException('El monto no es válido.');
        }
        if ((int)$monto <= 0) {
            throw new \InvalidArgumentException('El monto debe ser mayor que cero.');
        }
        $this->monto = (int)$monto;
    }

    public function setMontoME($montoME)
    {
        if (!preg_match('/^(?!0$)(?!1$)\d+([.,]\d+)?$/', $montoME)) {
            throw new \InvalidArgumentException('El monto no es válido.');
        }
        if ((int)$montoME <= 0) {
            throw new \InvalidArgumentException('El monto debe ser mayor que cero.');
        }
        $this->montoME = (int)$montoME;
    }

    public function setTotal($total)
    {
        if (!preg_match('/^(?!0$)(?!1$)\d+([.,]\d+)?$/', $total)) {
            throw new \InvalidArgumentException('El total no es válido.');
        }
        if ((int)$total <= 0) {
            throw new \InvalidArgumentException('El total debe ser mayor que cero.');
        }
        $this->total = (int)$total;
    }

    public function setTotalME($totalME)
    {
        if (!preg_match('/^(?!0$)(?!1$)\d+([.,]\d+)?$/', $totalME)) {
            throw new \InvalidArgumentException('El totalME no es válido.');
        }
        if ((int)$totalME <= 0) {
            throw new \InvalidArgumentException('El totalME debe ser mayor que cero.');
        }
        $this->totalME = (int)$totalME;
    }
    public function setPatologiasId($patologias)
    {
        // no hay id seleccionado
        if (empty($patologias)) {
            $this->patologiasId = null;
            return;
        }
        foreach ($patologias as $patologia) {
            if (!preg_match('/^[0-9]+$/', $patologia)) {
                throw new \InvalidArgumentException('El ID no es válido.');
            }
            if ((int)$patologia <= 0) {
                throw new \InvalidArgumentException('El ID debe ser mayor que cero.');
            }
        }
        $this->patologiasId = $patologias;
    }
    public function setSintomasId($sintomasId)
    {
        // no hay id seleccionado
        if (empty($sintomasId)) {
            $this->sintomasId = null;
            return;
        }
        foreach ($sintomasId as $sintoma) {
            if (!preg_match('/^[0-9]+$/', $sintoma)) {
                throw new \InvalidArgumentException('El ID no es válido.');
            }
            if ((int)$sintoma <= 0) {
                throw new \InvalidArgumentException('El ID debe ser mayor que cero.');
            }
        }
        $this->sintomasId = $sintomasId;
    }

    public function setSeveridad($severidad)
    {
        $this->severidad = $severidad;
    }

    public function setNota($nota)
    {
        $this->nota = $nota;
    }

    public function setFechaRegreso($fechaRegreso)
    {
        $dt = \DateTime::createFromFormat('Y-m-d', $fechaRegreso);
        $fechaHoy = date("Y-m-d");

        if (!$dt || $dt->format('Y-m-d') !== $fechaRegreso) {
            throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
        }
        if ($fechaRegreso <= $fechaHoy) {
            throw new \InvalidArgumentException("La fecha no puede ser del pasado.");
        }

        $this->fechaRegreso = $fechaRegreso;
    }

    public function setDiagnostico($diagnostico)
    {
        if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $diagnostico)) {
            throw new \InvalidArgumentException("el diagnostico debe estar completa y detallada.");
        }

        $this->diagnostico = $diagnostico;
    }


    public function setHistorial($historial)
    {
        if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $historial)) {
            throw new \InvalidArgumentException("El historial debe estar completa y detallada.");
        }

        $this->historial = $historial;
    }

    public function setIndicaciones($indicaciones)
    {

        if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $indicaciones)) {
            throw new \InvalidArgumentException("lasindicaciones debe estar completa y detallada.");
        }
        $this->indicaciones  = $indicaciones;
    }

    public function setCedula($cedula)
    {
        if (!preg_match("/^([1-9]{1})([0-9]{6,7})$/", $cedula)) {
            throw new \InvalidArgumentException("La cédula debe contener entre 7 y 8 dígitos.");
        }
        $this->cedula = $cedula;
    }

    public function setIdPaciente($id_paciente)
    {
        if (!preg_match("/^[0-9]+$/", $id_paciente)) {
            throw new \InvalidArgumentException("El ID del paciente debe ser un número entero positivo.");
        }

        if ((int)$id_paciente <= 0) {
            throw new \InvalidArgumentException("El ID del paciente debe ser mayor que cero.");
        }

        $this->id_paciente = (int)$id_paciente;
    }

    public function setIdDoctor($id_doctor)
    {
        if (!preg_match("/^[0-9]+$/", $id_doctor)) {
            throw new \InvalidArgumentException("El ID del doctor debe ser un número entero positivo.");
        }

        if ((int)$id_doctor <= 0) {
            throw new \InvalidArgumentException("El ID del doctor debe ser mayor que cero.");
        }
        $this->id_doctor = $id_doctor;
    }



    // getters
    public function getIdDoctor()
    {
        return $this->id_doctor;
    }

    public function getIdPaciente()
    {
        return $this->id_paciente;
    }

    public function getCedula()
    {
        return $this->cedula;
    }

    public function getIndicaciones()
    {
        return $this->indicaciones;
    }

    public function getHistorial()
    {
        return $this->historial;
    }

    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    public function getFechaDeRegreso()
    {
        return $this->fechaRegreso;
    }

    public function getNota()
    {
        return $this->nota;
    }

    public function getSeveridad()
    {
        return $this->severidad;
    }

    public function getPatologiasId()
    {
        return $this->patologiasId;
    }
    public function getSintomasId()
    {
        return $this->sintomasId;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getTotalME()
    {
        return $this->totalME;
    }

    public function getMonto()
    {
        return $this->monto;
    }

    public function getMontoME()
    {
        return $this->montoME;
    }

    public function getFechaHoraFinal()
    {
        return $this->fechaHoraFinal;
    }

    public function getIdInsumosA()
    {
        return $this->idInsumosA;
    }

    public function getCantidadE()
    {
        return $this->cantidadE;
    }
    public function getCantidadA()
    {
        return $this->cantidadA;
    }

    public function getIdInsElim()
    {
        return $this->idInsElim;
    }

    public function getIdInsH()
    {
        return $this->idInsH;
    }

    public function getFechaControl()
    {
        return $this->fechaControl;
    }

    public function getIdServicio()
    {
        return $this->idServicio;
    }

    public function getIdInsumo()
    {
        return $this->idInsumo;
    }

    public function getIdH()
    {
        return $this->idH;
    }

    public function getNombreInsumo()
    {
        return $this->nombreInsumo;
    }

    public function getFechaHora()
    {
        return $this->fechaHora;
    }

    public function getCantidadIns()
    {
        return $this->cantidadIns;
    }

    public function getCantidadSer()
    {
        return $this->cantidadSer;
    }
}
