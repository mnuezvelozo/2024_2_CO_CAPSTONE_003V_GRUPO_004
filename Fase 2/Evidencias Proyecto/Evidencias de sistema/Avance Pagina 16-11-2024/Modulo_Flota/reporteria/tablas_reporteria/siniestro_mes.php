<table class="table table-striped">
    <thead>
        <tr>
            <th>Mes</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($siniestro_data) > 0): ?>
            <?php foreach ($siniestro_data as $siniestro): ?>
                <tr>
                    <td><?= htmlspecialchars($siniestro['mes_nombre']) ?></td>
                    <td><?= htmlspecialchars($siniestro['cantidad']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">No hay siniestros registrados este año.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>