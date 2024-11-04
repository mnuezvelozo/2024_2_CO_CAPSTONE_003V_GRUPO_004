<?php
session_start();

// Verifica si el usuario ha iniciado sesión y tiene rol de supervisor o admin
if (!isset($_SESSION['rut']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)) {
    // Si no está autenticado o no tiene permisos, redirige al login
    header("Location: ../login/login.php");
    exit();
}

// Conexión a la base de datos
include("../conexion.php");

// Consultar todas las solicitudes de combustible
$sql_solicitudes = "
    SELECT sc.id_solicitud, sc.patente, sc.kilometraje, sc.fecha, sc.monto, sc.estado, sc.rut 
    FROM solicitud_combustible sc
    JOIN usuario u ON sc.rut = u.rut
    WHERE u.supervisor = ? OR ? = 1";  // Si es admin (rol = 1), puede ver todas las solicitudes

$stmt = $conexion->prepare($sql_solicitudes);
$stmt->bind_param("ss", $_SESSION['rut'], $_SESSION['rol']);
$stmt->execute();
$resultado_solicitudes = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Css -->
    <link rel="stylesheet" type="text/css" href="../estilos_generales/sidebar.css">
    <!--Bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <!-- Datatables -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link rel="shortcut icon" href="../img/logo.png" />
    <title>Historial de Solicitudes</title>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="cuadricula">
            <a href="">
                <img src="../img/logo.png" alt="Logo" class="logo_Blanco">
            </a>
            <hr class="sidebarHr">
            <a class="elemento" href="lista_solicitud.php">Solicitud de Combustible</a>
            <a class="elemento activo" href="">Solicitudes Actuales</a>
            <a class="elemento sub" href="../index.php">⏪ Regresar</a>
        </div>

        <!-- Dropdown Menú -->
        <div class="dropdown">
            <hr class="sidebarHr">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../img/logo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <!-- Mostrar nombre de usuario, o 'Usuario' si no está definido -->
                <strong><?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Usuario'; ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu text-small shadow">
                <li><a class="dropdown-item" href="../actualizar_perfil/actualizar_perfil.php">Actualizar Perfil</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="/modulo_flota/login/cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>

    <!-- Contenido -->
    <main class="content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Solicitudes Actuales</h1>
        </div>

        <table id="tabla_solicitudes" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID Solicitud</th>
                    <th>Patente</th>
                    <th>Kilometraje</th>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Estado</th>
                    <th>Rut Chofer</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado_solicitudes && $resultado_solicitudes->num_rows > 0): ?>
                    <?php while ($solicitud = $resultado_solicitudes->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($solicitud['id_solicitud']) ?></td>
                            <td><?= htmlspecialchars($solicitud['patente']) ?></td>
                            <td><?= htmlspecialchars($solicitud['kilometraje']) ?></td>
                            <td><?= htmlspecialchars($solicitud['fecha']) ?></td>
                            <td><?= '$' . number_format($solicitud['monto'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($solicitud['estado']) ?></td>
                            <td><?= htmlspecialchars($solicitud['rut']) ?></td>
                            <td>
                                <?php if ($solicitud['estado'] === 'Pendiente'): ?>
                                    <!-- Botones para aprobar o denegar -->
                                    <form action="php/gestionar_solicitud.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id_solicitud" value="<?= $solicitud['id_solicitud'] ?>">
                                        <input type="hidden" name="accion" value="aprobar">
                                        <button type="submit" class="btn btn-success btn-sm">Aprobar</button>
                                    </form>
                                    <form action="php/gestionar_solicitud.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id_solicitud" value="<?= $solicitud['id_solicitud'] ?>">
                                        <input type="hidden" name="accion" value="denegar">
                                        <button type="submit" class="btn btn-danger btn-sm">Denegar</button>
                                    </form>
                                <?php else: ?>
                                    <?= htmlspecialchars($solicitud['estado']) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile ?>
                <?php else: ?>
                    <!-- Si no hay solicitudes, asegúrate de que esta fila tenga 8 columnas -->
                    <tr>
                        <td colspan="8" class="text-center">No hay solicitudes de combustible registradas.</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </main>

    <!-- Inicializar DataTables -->
    <script>
        $(document).ready(function() {
            $('#tabla_solicitudes').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-CL.json',
                },
                order: [
                    [0, 'desc']
                ]
            });
        });

        // Capturar el evento submit de los formularios de aprobar/denegar
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Evita el envío estándar del formulario

                // Obtener los valores del formulario
                const accion = form.querySelector('input[name="accion"]').value;
                const id_solicitud = form.querySelector('input[name="id_solicitud"]').value;

                // Establecer título y texto según la acción
                const titulo = (accion === 'aprobar') ? '¿Aprobar Solicitud?' : '¿Denegar Solicitud?';
                const textoConfirmacion = (accion === 'aprobar') ? 'La solicitud se aprobará.' : 'La solicitud se denegará.';
                const textoExito = (accion === 'aprobar') ? 'Solicitud aprobada exitosamente.' : 'Solicitud denegada exitosamente.';

                // Mostrar alerta de confirmación con SweetAlert
                Swal.fire({
                    title: titulo,
                    text: textoConfirmacion,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar el formulario con AJAX
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", form.action, true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                        // Preparar los datos del formulario para enviar
                        var formData = new FormData(form);
                        var data = new URLSearchParams(formData).toString();

                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Mostrar alerta de éxito
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: textoExito,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Recargar la página después de cerrar la alerta
                                    window.location.reload();
                                });
                            } else if (xhr.readyState === 4) {
                                // Mostrar alerta de error si la solicitud falla
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'No se pudo gestionar la solicitud.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        };

                        // Enviar la solicitud
                        xhr.send(data);
                    }
                });
            });
        });
    </script>

</body>

</html>

<?php
$conexion->close();
?>