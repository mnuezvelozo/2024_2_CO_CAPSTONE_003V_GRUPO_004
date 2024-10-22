<table class="table table-striped">
    <thead>
        <tr>
            <th>Estado</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($estado_siniestro_data) > 0): ?>
            <?php foreach ($estado_siniestro_data as $estado_siniestro): ?>
                <tr>
                    <td><?= htmlspecialchars($estado_siniestro['estado']) ?></td>
                    <td><?= htmlspecialchars($estado_siniestro['cantidad']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>