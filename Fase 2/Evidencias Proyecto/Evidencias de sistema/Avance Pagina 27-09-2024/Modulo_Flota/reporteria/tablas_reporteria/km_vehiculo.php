<table class="table table-striped">
    <thead>
        <tr>
            <th>Vehículo</th>
            <th>Kilometraje Total</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($vehiculo_data) > 0): ?>
            <?php foreach ($vehiculo_data as $km_vehiculo): ?>
                <tr>
                    <td><?= htmlspecialchars($km_vehiculo['patente']) ?></td>
                    <td><?= htmlspecialchars($km_vehiculo['total_km']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>