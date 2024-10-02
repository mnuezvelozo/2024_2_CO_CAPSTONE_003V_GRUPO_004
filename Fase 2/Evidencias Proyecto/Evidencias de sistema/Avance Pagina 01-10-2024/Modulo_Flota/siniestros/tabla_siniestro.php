<?php
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['rut'])) {
    // Si no está autenticado, redirige al login
    header("Location: ../login/login.php");
    exit();
}

// Solo admin y supervisores pueden acceder a esta página
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 && $_SESSION['rol'] != 3) {
    header("Location: ../index.php?error=No tienes permisos para acceder a esta página.");
    exit();
}

include("../conexion.php");

// Consulta para obtener el listado de siniestros
$sql_tabla_siniestro = "
    SELECT 
        s.id_siniestro, 
        s.patente, 
        v.marca, 
        v.modelo, 
        s.fecha, 
        ts.estado AS tipo_siniestro_estado, 
        s.daño, 
        u.nombre AS nombre_usuario
    FROM siniestro s
    LEFT JOIN vehiculo v ON s.patente = v.patente
    LEFT JOIN tipo_siniestro ts ON s.id_tipo_siniestro = ts.id_tipo_siniestro
    LEFT JOIN usuario u ON s.rut = u.rut
    ORDER BY s.id_siniestro DESC"; // Ordenar por fecha descendente

$resultado = $conexion->query($sql_tabla_siniestro);
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
            <a class="elemento sub activo" href="">Listado Siniestros</a>
            <a class="elemento sub" href="registro_siniestro.php">Reportar Siniestros</a>
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
            <h2>Listado de Siniestros</h2>
            <br>
            <div class="row mb-3">
                <table id="tabla_siniestros" class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Numero Siniestro</th>
                            <th>Vehículo</th>
                            <th>Fecha</th>
                            <th>Estado Siniestro</th>
                            <th>Daño</th>
                            <th>Responsable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($siniestro = $resultado->fetch_assoc()) : ?>
                            <tr>
                                <td><?= htmlspecialchars($siniestro['id_siniestro']) ?></td>
                                <td><?= htmlspecialchars($siniestro['patente']) . " / " . htmlspecialchars($siniestro['marca']) . " " . htmlspecialchars($siniestro['modelo']) ?></td>
                                <td><?= htmlspecialchars($siniestro['fecha']) ?></td>
                                <td><?= htmlspecialchars($siniestro['tipo_siniestro_estado']) ?></td>
                                <td><?= htmlspecialchars($siniestro['daño']) ?></td>
                                <td><?= htmlspecialchars($siniestro['nombre_usuario']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#tabla_siniestros').DataTable({
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-CL.json',
                    },
                    order: [
                        [0, 'desc'] // Ordenar por la fecha (columna 3) en orden descendente
                    ]
                });
            });
        </script>
    </main>

</body>

</html>

<?php
$conexion->close();
?>