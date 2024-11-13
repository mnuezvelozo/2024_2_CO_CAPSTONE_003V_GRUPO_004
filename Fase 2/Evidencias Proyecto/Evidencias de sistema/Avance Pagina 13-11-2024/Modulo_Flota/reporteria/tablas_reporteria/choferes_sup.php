<table class="table table-striped">
    <thead>
        <tr>
            <th>Supervisor</th>
            <th>Cantidad de Choferes</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($choferes_por_supervisor_data) > 0): ?>
            <?php foreach ($choferes_por_supervisor_data as $choferes_por_supervisor): ?>
                <tr>
                    <td><?= htmlspecialchars($choferes_por_supervisor['supervisor_nombre']) ?></td>
                    <td><?= htmlspecialchars($choferes_por_supervisor['cantidad_choferes']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
