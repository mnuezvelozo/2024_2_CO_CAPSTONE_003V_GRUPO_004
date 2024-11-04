<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['rut'])) {
    header("Location: ../login/login.php");
    exit();
}

// Conexión a la base de datos
include("../conexion.php");

// Determinar si es chofer, supervisor o administrador
$is_chofer = ($_SESSION['rol'] == 3);
$is_supervisor = ($_SESSION['rol'] == 2);

// Modificar la consulta para filtrar vehículos según el usuario logueado
$sql_vehiculo = "
    SELECT v.patente, v.marca, v.modelo, v.año, v.km_actual, v.fecha_revision_tecnica, v.rut, u.nombre, v.activo
    FROM vehiculo v
    LEFT JOIN usuario u ON v.rut = u.rut
    WHERE v.activo = 'si'";

// Si es chofer, mostrar solo sus vehículos
if ($is_chofer) {
    $sql_vehiculo .= " AND v.rut = ?";
} elseif ($is_supervisor) {
    // Si es supervisor, mostrar vehículos de los usuarios a su cargo
    $sql_vehiculo .= " AND (u.supervisor = ? OR v.rut = ?)";
}

$stmt_vehiculo = $conexion->prepare($sql_vehiculo);

// Vincular parámetros dependiendo del rol
if ($is_chofer) {
    $stmt_vehiculo->bind_param("s", $_SESSION['rut']);
} elseif ($is_supervisor) {
    $stmt_vehiculo->bind_param("ss", $_SESSION['rut'], $_SESSION['rut']);
}

$stmt_vehiculo->execute();
$resultado_vehiculo = $stmt_vehiculo->get_result();
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
    <title>Modulo Flota | Vehículos</title>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="cuadricula">
            <a href="">
                <img src="../img/logo.png" alt="Logo" class="logo_Blanco">
            </a>
            <hr class="sidebarHr">
            <a class="elemento activo" href="">Registro de Vehiculos</a>
            <a class="elemento sub" href="../index.php">⏪ Regresar</a>
        </div>

        <!-- Dropdown Menú -->
        <div class="dropdown">
            <hr class="sidebarHr">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../img/logo.png" alt="" width="32" height="32" class="rounded-circle me-2">
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
        <?php require_once("componentes/tabla_vehiculos_chofer.php") ?>

        <!-- Mostrar la alerta si hay un estado de actualización -->
        <?php if (isset($_GET['status']) && isset($_GET['mensaje'])): ?>
            <script>
                Swal.fire({
                    icon: '<?php echo htmlspecialchars($_GET['status']); ?>',
                    title: '<?php echo htmlspecialchars($_GET['mensaje']); ?>',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    timer: 3000
                });
                // Redirigir a la misma URL sin los parámetros de estado y mensaje
                const url = new URL(window.location);
                url.searchParams.delete('status');
                url.searchParams.delete('mensaje');
                window.history.replaceState(null, null, url);
            </script>
        <?php endif; ?>
    </main>
</body>

</html>