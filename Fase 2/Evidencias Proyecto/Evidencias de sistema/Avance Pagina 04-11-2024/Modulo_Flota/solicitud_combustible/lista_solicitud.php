<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['rut'])) {
    // Si no está autenticado, redirige al login
    header("Location: ../login/login.php");
    exit();
}

// Conexión a la base de datos
include("../conexion.php");

// Consultar las solicitudes de combustible del chofer actual
$rut = $_SESSION['rut'];
$sql_solicitudes = "
    SELECT s.id_solicitud, s.patente, s.kilometraje, s.fecha, s.monto, s.estado, u.nombre AS nombre_autorizador
    FROM solicitud_combustible s
    LEFT JOIN usuario u ON s.rut_autorizador = u.rut
    WHERE s.rut = ?";
$stmt_solicitudes = $conexion->prepare($sql_solicitudes);
$stmt_solicitudes->bind_param('s', $rut);
$stmt_solicitudes->execute();
$resultado_solicitudes = $stmt_solicitudes->get_result();
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Css -->
    <link rel="stylesheet" type="text/css" href="../estilos_generales/sidebar.css">
    <!--Bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <!-- Select2 -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/1abf3059f8.js" crossorigin="anonymous"></script>
    <!-- Datatables -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link rel="shortcut icon" href="../img/logo.png" />
    <title>Modulo Flota | Solicitud de combustible</title>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="cuadricula">
            <a href="">
                <img src="../img/logo.png" alt="Logo" class="logo_Blanco">
            </a>
            <hr class="sidebarHr">
            <a class="elemento activo" href="">Solicitud de Combustible</a>
            <a class="elemento" href="lista_solicitudes.php">Solicitudes Actuales</a>
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
            <h1>Solicitudes de Combustible</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarSolicitud">
                Agregar Solicitud
            </button>
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
                    <th>Nombre Autorizador</th>
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
                            <td><?= '$' . number_format($solicitud['monto'], 0, ',', '.') ?></td> <!-- Formato CLP -->
                            <td><?= htmlspecialchars($solicitud['estado']) ?></td>
                            <td><?= htmlspecialchars($solicitud['nombre_autorizador'] ?? 'Pendiente') ?></td> <!-- Mostrar el nombre del autorizador o 'N/A' si no hay -->
                        </tr>
                    <?php endwhile ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No hay solicitudes de combustible registradas.</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>

        <!-- Modal para agregar solicitud -->
        <?php require_once("componentes/modal_agregar_solicitud.php") ?>
    </main>

    <!-- Inicialización de DataTables -->
    <script>
        $(document).ready(function() {
            <?php if ($resultado_solicitudes && $resultado_solicitudes->num_rows > 0): ?>
                $('#tabla_solicitudes').DataTable({
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-CL.json',
                    },
                    order: [
                        [0, 'desc']
                    ]
                });
            <?php endif; ?>
        });
    </script>


</body>

</html>
<?php
$conexion->close();
?>