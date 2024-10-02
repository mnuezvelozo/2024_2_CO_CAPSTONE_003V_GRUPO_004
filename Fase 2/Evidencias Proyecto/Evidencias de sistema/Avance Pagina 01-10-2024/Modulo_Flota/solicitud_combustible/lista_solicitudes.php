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
    SELECT id_solicitud, patente, kilometraje, fecha, monto, estado, rut 
    FROM solicitud_combustible";
$resultado_solicitudes = $conexion->query($sql_solicitudes);
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
                <li><a class="dropdown-item" href="#">Creacion de Usuario</a></li>
                <li><a class="dropdown-item" href="#">Actualizar Perfil</a></li>
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
                            <td><?= '$' . number_format($solicitud['monto'], 0, ',', '.') ?></td> <!-- Formato CLP -->
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
                                    <!-- Si ya fue gestionada -->
                                    <?= htmlspecialchars($solicitud['estado']) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile ?>
                <?php else: ?>
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
    </script>

</body>
</html>

<?php
$conexion->close();
?>
