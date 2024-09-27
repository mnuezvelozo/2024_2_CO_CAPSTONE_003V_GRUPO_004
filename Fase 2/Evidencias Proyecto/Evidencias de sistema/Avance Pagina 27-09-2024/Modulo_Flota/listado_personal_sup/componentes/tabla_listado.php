<div class="row">
    <div class="col">
        <h1>Listado de Personal</h1>
    </div>
</div>

<?php
if (!isset($conexion)) {
    include($_SERVER['DOCUMENT_ROOT'] . "/Modulo_Flota/conexion.php");
}

// Consulta para obtener el personal junto con su rol y el Id_Rol
$sql_personal = "
    SELECT u.rut, u.nombre, u.fecha_ingreso, u.Id_Rol, r.nombre_rol, 
           CASE WHEN u.Usuario IS NOT NULL AND u.Usuario != '' THEN 'Sí' ELSE 'No' END AS posee_cuenta
    FROM usuario u
    LEFT JOIN roles r ON u.Id_Rol = r.Id_Rol;
";

$stmt_personal = $conexion->prepare($sql_personal);
$stmt_personal->execute();
$resultado_personal = $stmt_personal->get_result();
?>

<table id="tabla_personal" class="table table-striped">
    <thead>
        <tr>
            <th style="width: 20%;">RUT</th>
            <th style="width: 20%;">Nombre</th>
            <th style="width: 20%;">Fecha de Ingreso</th>
            <th style="width: 20%;">Rol</th>
            <th style="width: 15%;">¿Posee cuenta?</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($resultado_personal as $personal) : ?>
            <tr>
                <td><?= htmlspecialchars($personal['rut']) ?></td>
                <td><?= htmlspecialchars($personal['nombre']) ?></td>
                <td><?= htmlspecialchars($personal['fecha_ingreso']) ?></td>
                <td><?= htmlspecialchars($personal['nombre_rol']) ?></td>
                <td><?= htmlspecialchars($personal['posee_cuenta']) ?></td> 
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php mysqli_commit($conexion) ?>

<script>
    $(document).ready(function() {
        $('#tabla_personal').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-CL.json',
            },
            order: [
                [0, 'desc']
            ]
        });
    });
</script>