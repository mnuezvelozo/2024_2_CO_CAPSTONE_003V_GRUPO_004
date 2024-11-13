<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['rut'])) {
    // Si no está autenticado, redirige al login
    header("Location: ../login/login.php");
    exit();
}

// Verifica si el usuario tiene el rol adecuado (por ejemplo, admin con rol = 1)
if ($_SESSION['rol'] != 1) {
    // Si no tiene el rol adecuado, redirige a una página de error o al index con un mensaje
    header("Location: ../index.php?error=No tienes permisos para acceder a esta página.");
    exit();
}

include("../conexion.php");
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Css -->
    <link rel="stylesheet" type="text/css" href="../estilos_generales/sidebar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!--Bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/1abf3059f8.js" crossorigin="anonymous"></script>
    <!-- Datatables -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link rel="shortcut icon" href="../img/logo.png" />
    <title>Modulo Flota | Cuentas</title>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="cuadricula">
            <a href="">
                <img src="../img/logo.png" alt="Logo" class="logo_Blanco">
            </a>
            <hr class="sidebarHr">
            <a class="elemento activo" href="">Cuentas</a>
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
        <?php require_once("componentes/lista_cuentas.php") ?>
        <?php require_once("componentes/modal_agregar_cuenta.php") ?>
        <?php require_once("componentes/modal_eliminar_cuenta.php") ?>
        <?php require_once("componentes/modal_actualizar_cuenta.php") ?>

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
