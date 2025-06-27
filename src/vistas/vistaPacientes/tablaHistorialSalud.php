<!-- Historial salud para incluir -->
<div class="table table-responsive">
    <table class="example table table-striped">
        <thead>
            <tr>
                <th class="text-dark">Cédula</th>
                <th class="text-dark">Nombre y Apellido</th>
                <th class="text-dark">Diagnóstico</th>
                <th class="text-dark">Ultima visita</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historial as $item): ?>
                <tr>
                    <td class="tex-center"><?= $item['cedula_paciente'] ?></td>
                    <td class="text-center"><?= $item['nombre_paciente'] . ' ' . $item['apellido_paciente'] ?></td>
                    <td class="text-center"><?= $item['estado_nuevo'] ?></td>
                    <td class="text-center"><?= $item['fecha_cambio'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>