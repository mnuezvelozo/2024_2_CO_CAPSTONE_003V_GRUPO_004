<table class="table table-striped">
    <thead>
        <tr>
            <th>Estado</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($vehiculos_activos_data) > 0): ?>
            <?php foreach ($vehiculos_activos_data as $vehiculo): ?>
                <tr>
                    <td><?= htmlspecialchars($vehiculo['activo'] == 'Si' ? 'Activo' : 'Inactivo') ?></td>
                    <td><?= htmlspecialchars($vehiculo['cantidad']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>