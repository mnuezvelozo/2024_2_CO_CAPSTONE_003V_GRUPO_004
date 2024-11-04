<?php
session_start();

// Verifica si el usuario ha iniciado sesión y tiene un rol definido
if (!isset($_SESSION['rut']) || !isset($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}

include("conexion.php");

$rol = $_SESSION['rol']; // Obtener el rol del usuario desde la sesión

// Si el usuario es un chofer, contar sus auditorías pendientes
$total_pendientes = 0;
if ($rol == 3) { // Chofer
    $rut_responsable = $_SESSION['rut'];
    $sql = "SELECT COUNT(*) as total_pendientes FROM auditoria WHERE rut_responsable = '$rut_responsable' AND estado = 'Pendiente'";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_pendientes = $row['total_pendientes'];
}
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="estilos_generales/sidebar.css">
    <link rel="stylesheet" type="text/css" href="estilos_generales/formulario.css">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Título e Ícono -->
    <link rel="shortcut icon" href="img/logo.png" />
    <title>Modulo Flota | Principal</title>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="cuadricula">
            <a href="">
                <img src="img/logo.png" alt="Logo" class="logo_Blanco">
            </a>
            <hr class="sidebarHr">

            <!-- Enlaces de menú según el rol del usuario -->
            <?php if (isset($rol)): ?>
                <?php if ($rol == 1): // Admin ?>
                    <a class="elemento" href="personal/lista_empleados.php">Administración de Personal</a>
                    <a class="elemento" href="cuentas/cuentas.php">Administración de Cuentas</a>
                    <a class="elemento" href="registro_vehiculos/vehiculos.php">Vehículos</a>
                    <a class="elemento" href="siniestros/tabla_siniestro.php">Siniestros</a>
                    <a class="elemento" href="solicitud_combustible/lista_solicitud.php">Solicitud de Combustible</a>
                    <a class="elemento" href="reporteria/reportes.php">Panel de Control y Reportes</a>
                    <a class="elemento" href="control_dinero/control_dinero.php">Control de Dinero</a>
                <?php elseif ($rol == 2): // Supervisor ?>
                    <a class="elemento" href="listado_personal_sup/listado_personal.php">Listado de Personal</a>
                    <a class="elemento" href="registro_vehiculos/vehiculos.php">Vehículos</a>
                    <a class="elemento" href="siniestros/tabla_siniestro.php">Siniestros</a>
                    <a class="elemento" href="solicitud_combustible/lista_solicitud.php">Solicitud de Combustible</a>
                    <a class="elemento" href="reporteria/reportes.php">Panel de Control y Reportes</a>
                <?php elseif ($rol == 3): // Chofer ?>
                    <a class="elemento" href="listado_vehiculo_chofer/vehiculos_chofer.php">Reporte de Vehiculos</a>
                    <a class="elemento" href="siniestros/tabla_siniestro.php">Siniestros</a>
                    <a class="elemento" href="solicitud_combustible/lista_vista_chofer.php">Solicitud de Combustible</a>
                    <a class="elemento" href="auditoria/auditoria_pendientes.php">
                        Auditoría 
                        <?php if ($total_pendientes > 0): ?>
                            <span class="badge rounded-circle bg-primary text-white ms-1"><?php echo $total_pendientes; ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <p>Error: El rol del usuario no está definido.</p>
            <?php endif; ?>
        </div>

        <!-- Dropdown Menú -->
        <div class="dropdown">
            <hr class="sidebarHr">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="img/logo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong><?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Usuario'; ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu text-small shadow">
                <li><a class="dropdown-item" href="actualizar_perfil/actualizar_perfil.php">Actualizar Perfil</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="/modulo_flota/login/cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>

    <!-- Contenido -->
    <main class="content">
        <img class="logo" src="img/logo.png" alt="Logo Dominion">
        <h1>Bienvenido/a, <?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Usuario'; ?></h1>

        <?php if (isset($_GET['error'])): ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '<?php echo htmlspecialchars($_GET['error']); ?>',
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                });
            </script>
        <?php endif; ?>
    </main>
</body>

</html>
