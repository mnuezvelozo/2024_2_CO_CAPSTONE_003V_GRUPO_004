<div class="row">
    <div class="col">
        <h1>Gestión de Personal</h1>
    </div>

    <div class="col-auto">
        <form action="" method="POST">
            <input type="hidden" name="tipo_vista" value="editar">
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalAgregarPersonal">
                Registrar Empleados
            </button>
        </form>
    </div>
</div>

<?php
if (!isset($conexion)) {
    include($_SERVER['DOCUMENT_ROOT'] . "/Modulo_Flota/conexion.php");
}

// Consulta para obtener el personal junto con su rol y el Id_Rol
$sql_personal = "
    SELECT u.rut, u.nombre, u.fecha_ingreso, c.nombre_cargo, c.id_cargo, 
           COALESCE(s.nombre, 'N/A') as nombre_supervisor
    FROM usuario u
    LEFT JOIN cargo c ON u.id_cargo = c.id_cargo
    LEFT JOIN usuario s ON u.supervisor = s.rut;
";

$stmt_personal = $conexion->prepare($sql_personal);
$stmt_personal->execute();
$resultado_personal = $stmt_personal->get_result();
?>

<table id="tabla_personal">
    <thead>
        <tr>
            <th style="width: 20%;">RUT</th>
            <th style="width: 20%;">Nombre</th>
            <th style="width: 20%;">Fecha de Ingreso</th>
            <th style="width: 20%;">Cargo</th>
            <th style="width: 20%;">Supervisor</th>
            <th style="width: 20%;">Acción</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($resultado_personal as $personal) : ?>
            <tr>
                <td><?= htmlspecialchars($personal['rut']) ?></td>
                <td><?= htmlspecialchars($personal['nombre']) ?></td>
                <td><?= htmlspecialchars($personal['fecha_ingreso']) ?></td>
                <td><?= htmlspecialchars($personal['nombre_cargo']) ?></td>
                <td><?= htmlspecialchars($personal['nombre_supervisor']) ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn no-colapse" style="color: #cfbb4a" data-bs-toggle="modal" data-bs-target="#modal_actualizar"
                            onclick="completar_datos_modal_actualizar('<?= htmlspecialchars($personal['rut']) ?>', '<?= htmlspecialchars($personal['nombre']) ?>', '<?= htmlspecialchars($personal['fecha_ingreso']) ?>', '<?= htmlspecialchars($personal['id_cargo']) ?>', '<?= htmlspecialchars($personal['nombre']) ?>')">
                            <i class="fa-regular fa-pen-to-square"></i>
                            &nbsp;
                            <span class="subrayado">Actualizar</span>
                        </button>


                        <button class="btn no-colapse" style="color: #ff0000" data-bs-toggle="modal" data-bs-target="#modal_eliminar" onclick="completar_datos_modal_eliminar('<?= htmlspecialchars($personal['rut']) ?>')">
                            <i class="fa-regular fa-trash-can"></i>
                            &nbsp;
                            <span class="subrayado">Eliminar</span>
                        </button>
                    </div>
                </td>
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

    function completar_datos_modal_actualizar(rut, nombre, fecha_ingreso, id_cargo, supervisor) {
        document.getElementById("input_rut").value = rut;
        document.getElementById("input_nombre").value = nombre;
        document.getElementById("input_fecha_ingreso").value = fecha_ingreso;
        document.getElementById("input_cargo").value = id_cargo;
        document.getElementById("input_supervisor").value = supervisor;
    }

    function completar_datos_modal_eliminar(rut) {
        document.getElementById("rut_eliminar").value = rut;
    }
</script>