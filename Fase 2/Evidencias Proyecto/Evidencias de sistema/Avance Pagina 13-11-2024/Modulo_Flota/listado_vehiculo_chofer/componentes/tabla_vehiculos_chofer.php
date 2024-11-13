<div class="row">
    <div class="col">
        <h1>Gestión de Flota</h1>
    </div>
</div>



<?php
if (!isset($conexion)) {
    include($_SERVER['DOCUMENT_ROOT'] . "/Modulo_Flota/conexion.php");
}

// Modificar la consulta para filtrar vehículos según el usuario logueado
$sql_vehiculo = "
    SELECT v.patente, v.marca, v.modelo, v.año, v.km_actual, v.fecha_revision_tecnica, v.rut, u.nombre, v.activo
    FROM vehiculo v
    LEFT JOIN usuario u ON v.rut = u.rut
    WHERE v.activo = 'si'";

// Si es chofer, mostrar solo sus vehículos
if ($_SESSION['rol'] == 3) {
    $sql_vehiculo .= " AND v.rut = ?";
} elseif ($_SESSION['rol'] == 2) {
    // Si es supervisor, mostrar vehículos de los usuarios a su cargo
    $sql_vehiculo .= " AND (u.supervisor = ? OR v.rut = ?)";
}

$stmt_vehiculo = $conexion->prepare($sql_vehiculo);

// Vincular parámetros dependiendo del rol
if ($_SESSION['rol'] == 3) {
    $stmt_vehiculo->bind_param("s", $_SESSION['rut']);
} elseif ($_SESSION['rol'] == 2) {
    $stmt_vehiculo->bind_param("ss", $_SESSION['rut'], $_SESSION['rut']);
}

$stmt_vehiculo->execute();
$resultado_vehiculo = $stmt_vehiculo->get_result();
?>

<table id="tabla_vehiculo" class="table table-striped">
    <thead>
        <tr>
            <th style="width: 10%;">Patente</th>
            <th style="width: 10%;">Marca</th>
            <th style="width: 10%;">Modelo</th>
            <th style="width: 10%;">Año</th>
            <th style="width: 10%;">Km Actual</th>
            <th style="width: 10%;">Revision Tecnica</th>
            <th style="width: 10%;">Nombre Responsable</th>
            <th style="width: 10%;">Acción</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($resultado_vehiculo as $vehiculo) : ?>
            <tr>
                <td><?= htmlspecialchars($vehiculo['patente']) ?></td>
                <td><?= htmlspecialchars($vehiculo['marca']) ?></td>
                <td><?= htmlspecialchars($vehiculo['modelo']) ?></td>
                <td><?= htmlspecialchars($vehiculo['año']) ?></td>
                <td><?= $vehiculo['km_actual'] ? number_format($vehiculo['km_actual'], 0, ',', '.') . ' km' : '' ?></td>
                <td><?= (new DateTime($vehiculo['fecha_revision_tecnica']))->format('d/m/Y') ?></td>
                <td><?= htmlspecialchars($vehiculo['nombre']) ?></td>
                <td>

                    <form action="detalle_vehiculo_chofer.php" method="GET" class="me-2">
                        <input type="hidden" name="patente" value="<?= htmlspecialchars($vehiculo['patente']) ?>">
                        <button class="btn no-colapse" style="color: #3b6bee">
                            <i class="fa-solid fa-bars"></i>
                            &nbsp;
                            <span class="subrayado">Detalle</span>
                        </button>
                    </form>

                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>


<?php mysqli_commit($conexion) ?>

<script>
    $(document).ready(function() {
        $('#tabla_vehiculo').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-CL.json',
            },
            order: [
                [0, 'desc']
            ]
        });
    });
</script>