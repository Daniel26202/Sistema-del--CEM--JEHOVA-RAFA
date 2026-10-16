<?php

namespace App\modelos;

/**
 * Consultas de solo lectura para el componente inteligente (FastAPI).
 *
 * Reúne los datos clínicos de un PACIENTE (no del usuario): el vínculo
 * usuario → paciente se resuelve por cédula (personal.cedula = paciente.cedula),
 * porque no existe una relación explícita en el esquema.
 */
class ModeloApi extends ModelBase
{
    public function __construct(bool $dbSystem = true)
    {
        parent::__construct($dbSystem);
    }

    /**
     * Indica si el usuario pertenece al personal del centro (doctor, secretaria
     * o administrador). Un "usuario normal" sin fila en `personal` no tiene acceso.
     */
    public function esPersonalDelCentro(int $idUsuario): bool
    {
        $this->setSQL("SELECT 1 AS existe FROM personal WHERE usuario = :id_usuario LIMIT 1");
        $fila = $this->search(['id_usuario' => $idUsuario], false);

        return !empty($fila);
    }

    /**
     * Devuelve el paciente asociado al usuario por cédula, o null si no hay.
     */
    public function pacienteDeUsuario(int $idUsuario): ?array
    {
        $this->setSQL(
            "SELECT p.id_paciente, p.cedula, p.nombre, p.apellido, p.genero, p.fn, p.estado_salud
             FROM personal pe
             INNER JOIN paciente p ON p.cedula = pe.cedula
             WHERE pe.usuario = :id_usuario
             LIMIT 1"
        );

        $fila = $this->search(['id_usuario' => $idUsuario], false);
        return $fila ?: null;
    }

    /**
     * Historial de controles del paciente, con los síntomas de cada control
     * agregados en un solo campo.
     */
    public function historialDePaciente(int $idPaciente): array
    {
        $this->setSQL(
            "SELECT c.id_control, c.fecha_control, c.fechaRegreso, c.diagnostico,
                    c.historiaclinica, c.medicamentosRecetados, c.nota, c.severidad, c.estado,
                    GROUP_CONCAT(s.nombre SEPARATOR ', ') AS sintomas
             FROM control c
             LEFT JOIN sintomas_control sc ON sc.id_control = c.id_control
             LEFT JOIN sintomas s ON s.id_sintomas = sc.id_sintomas
             WHERE c.id_paciente = :id_paciente
             GROUP BY c.id_control
             ORDER BY c.fecha_control DESC"
        );

        return $this->search(['id_paciente' => $idPaciente]) ?: [];
    }

    /**
     * Citas del paciente (con la categoría/servicio).
     */
    public function citasDePaciente(int $idPaciente): array
    {
        $this->setSQL(
            "SELECT c.id_cita, c.fecha, c.hora, c.estado, cs.nombre AS categoria
             FROM cita c
             INNER JOIN serviciomedico sm ON sm.id_servicioMedico = c.serviciomedico_id_servicioMedico
             INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria
             WHERE c.paciente_id_paciente = :id_paciente
             ORDER BY c.fecha DESC, c.hora DESC"
        );

        return $this->search(['id_paciente' => $idPaciente]) ?: [];
    }

    /**
     * Hospitalizaciones del paciente.
     */
    public function hospitalizacionesDePaciente(int $idPaciente): array
    {
        $this->setSQL(
            "SELECT id_hospitalizacion, fecha_hora_inicio, fecha_hora_final, estado, total
             FROM hospitalizacion
             WHERE id_paciente = :id_paciente
             ORDER BY fecha_hora_inicio DESC"
        );

        return $this->search(['id_paciente' => $idPaciente]) ?: [];
    }
}
