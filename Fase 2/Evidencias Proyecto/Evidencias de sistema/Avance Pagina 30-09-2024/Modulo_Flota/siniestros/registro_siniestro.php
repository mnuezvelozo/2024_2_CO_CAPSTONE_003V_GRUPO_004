<?php
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['rut'])) {
    // Si no está autenticado, redirige al login
    header("Location: ../login/login.php");
    exit();
}

// Solo admin y supervisores pueden acceder a esta página
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
    header("Location: ../index.php?error=No tienes permisos para acceder a esta página.");
    exit();
}

include("../conexion.php");

// Obtener las opciones de vehículos y tipos de siniestro
$sql_vehiculos = "SELECT patente, marca, modelo FROM vehiculo WHERE activo = 'si'";
$resultado_vehiculos = $conexion->query($sql_vehiculos);

$sql_tipo_siniestro = "SELECT id_tipo_siniestro, estado FROM tipo_siniestro";
$resultado_tipo_siniestro = $conexion->query($sql_tipo_siniestro);

// Obtener los usuarios
$sql_usuarios = "SELECT rut, nombre FROM usuario";
$resultado_usuarios = $conexion->query($sql_usuarios);
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
            <a class="elemento" href=""> Siniestros </a>
            <a class="elemento sub" href="tabla_siniestro.php">Listado Siniestros</a>
            <a class="elemento sub activo" href="">Reportar Siniestros</a>
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
                <li><a class="dropdown-item" href=""> Creacion de Usuario</a></li>
                <li><a class="dropdown-item" href="">Actualizar Perfil</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="/modulo_flota/login/cerrar_sesion.php">Cerrar Sesión</a></li>

            </ul>
        </div>
    </nav>
    <main>
        <div class="content">
            <h2>Registrar Siniestro</h2>
            <form action="php/procesar_siniestro.php" method="POST">
                <!-- Campo para seleccionar vehículo -->
                <div class="mb-3">
                    <label for="Patente" class="form-label">Ingrese el vehículo</label>
                    <select class="form-select" name="Patente" id="Patente" required>
                        <option value="" disabled selected>Seleccione un vehículo</option>
                        <?php while ($vehiculo = $resultado_vehiculos->fetch_assoc()) : ?>
                            <option value="<?= htmlspecialchars($vehiculo['patente']) ?>">
                                <?= htmlspecialchars($vehiculo['patente']) ?> - <?= htmlspecialchars($vehiculo['marca']) ?> <?= htmlspecialchars($vehiculo['modelo']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Campo para seleccionar el tipo de siniestro -->
                <div class="mb-3">
                    <label for="id_tipo_siniestro" class="form-label">Estado del Siniestro</label>
                    <select class="form-select" name="id_tipo_siniestro" id="id_tipo_siniestro" required>
                        <option value="" disabled selected>Seleccione el estado de siniestro</option>
                        <?php while ($tipo = $resultado_tipo_siniestro->fetch_assoc()) : ?>
                            <option value="<?= htmlspecialchars($tipo['id_tipo_siniestro']) ?>">
                                <?= htmlspecialchars($tipo['estado']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Campo para fecha del siniestro -->
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha del Siniestro</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>

                <!-- Campo para descripción del daño -->
                <div class="mb-3">
                    <label for="Daño" class="form-label">Descripción del Daño</label>
                    <textarea class="form-control" id="Daño" name="Daño" rows="3" required></textarea>
                </div>

                <!-- Campo para seleccionar el responsable (usuario) -->
                <div class="mb-3">
                    <label for="Rut" class="form-label">Usuario Responsable (Rut)</label>
                    <select class="form-select" name="Rut" id="Rut" required>
                        <option value="" disabled selected>Seleccione el responsable</option>
                        <?php while ($usuario = $resultado_usuarios->fetch_assoc()) : ?>
                            <option value="<?= htmlspecialchars($usuario['rut']) ?>">
                                <?= htmlspecialchars($usuario['rut']) ?> - <?= htmlspecialchars($usuario['nombre']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Registrar Siniestro</button>
            </form>
        </div>
        
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