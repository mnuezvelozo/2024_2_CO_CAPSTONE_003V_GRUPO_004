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

include('../conexion.php');

// Función para convertir el número del mes al nombre del mes
function obtenerNombreMes($numero_mes)
{
    $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];
    return $meses[$numero_mes];
}

// Consulta 1: Cantidad de siniestros por mes
$sql_siniestros_mes = " SELECT COUNT(id_siniestro) AS cantidad, MONTH(fecha) AS mes
    FROM siniestro
    WHERE YEAR(fecha) = YEAR(CURRENT_DATE)
    GROUP BY MONTH(fecha);
    ";
$stmt_siniestro = $conexion->prepare($sql_siniestros_mes);
$stmt_siniestro->execute();
$resultado_siniestro = $stmt_siniestro->get_result();
$siniestro_data = [];
while ($row_siniestro = $resultado_siniestro->fetch_assoc()) {
    $row_siniestro['mes_nombre'] = obtenerNombreMes($row_siniestro['mes']);
    $siniestro_data[] = $row_siniestro;
}

// Consulta 3: Estados de siniestros
$sql_estados_siniestro = "SELECT ts.estado, COUNT(s.id_siniestro) AS cantidad
    FROM siniestro s
    LEFT JOIN tipo_siniestro ts ON s.id_tipo_siniestro = ts.id_tipo_siniestro
    GROUP BY ts.estado
    ORDER BY cantidad desc;
    ";
$stmt_estado_siniestro = $conexion->prepare($sql_estados_siniestro);
$stmt_estado_siniestro->execute();
$resultado_estado_siniestro = $stmt_estado_siniestro->get_result();
$estado_siniestro_data = [];
while ($row_estado_siniestro = $resultado_estado_siniestro->fetch_assoc()) {
    $estado_siniestro_data[] = $row_estado_siniestro;
}

// Consulta 4: Vehículos activos vs. inactivos
$sql_vehiculos_activos = "
    SELECT activo, COUNT(*) AS cantidad
    FROM vehiculo
    GROUP BY activo
    ORDER BY cantidad DESC;
";

$stmt_vehiculos_activos = $conexion->prepare($sql_vehiculos_activos);
$stmt_vehiculos_activos->execute();
$resultado_vehiculos_activos = $stmt_vehiculos_activos->get_result();
$vehiculos_activos_data = [];
while ($row_vehiculos_activos = $resultado_vehiculos_activos->fetch_assoc()) {
    $vehiculos_activos_data[] = $row_vehiculos_activos;
}

// Consulta 5: Cantidad de choferes por supervisor

$sql_choferes_por_supervisor = "
    SELECT u_supervisor.nombre AS supervisor_nombre, COUNT(u.rut) AS cantidad_choferes
    FROM usuario u
    JOIN usuario u_supervisor ON u.supervisor = u_supervisor.rut
    WHERE u.supervisor IS NOT NULL
    GROUP BY u.supervisor
    ORDER BY cantidad_choferes DESC;
";

$stmt_choferes_por_supervisor = $conexion->prepare($sql_choferes_por_supervisor);
$stmt_choferes_por_supervisor->execute();
$resultado_choferes_por_supervisor = $stmt_choferes_por_supervisor->get_result();
$choferes_por_supervisor_data = [];
while ($row_choferes_por_supervisor = $resultado_choferes_por_supervisor->fetch_assoc()) {
    $choferes_por_supervisor_data[] = $row_choferes_por_supervisor;
}
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Css -->
    <link rel="stylesheet" type="text/css" href="../estilos_generales/sidebar.css">
    <link rel="stylesheet" type="text/css" href="../estilos_generales/detalle_vehiculo.css">
    <!--Bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/1abf3059f8.js" crossorigin="anonymous"></script>
    <!-- Datatables -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link rel="shortcut icon" href="../img/logo.png" />
    <title>Modulo Flota | Reportes</title>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="cuadricula">
            <a href=""><img src="../img/logo.png" alt="Logo" class="logo_Blanco"></a>
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

    <div class="content">
        <h1 class="text-center">Panel de Reportes</h1>
        <hr>
        <br>


        <!-- Grafico y tabla de cantidad de choferes por supervisor -->
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <h3>Cantidad de choferes por supervisor</h3>
                    <br>
                    <canvas id="choferesPorSupervisorChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <div class="vehiculo-table-responsive">
                    <?php require_once("tablas_reporteria/choferes_sup.php") ?>
                </div>
            </div>
        </div>
        <hr>
        <br>

        <!-- Gráfico y tabla de siniestros por mes -->
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <h3>Cantidad de Siniestros por Mes</h3>
                    <br>
                    <canvas id="siniestrosMesChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <div class="vehiculo-table-responsive">
                    <?php require_once("tablas_reporteria/siniestro_mes.php") ?>
                </div>
            </div>
        </div>
        <hr>
        <br>

        <!-- Gráfico y tabla de estado de siniestros -->
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <h3>Estado de Siniestros</h3>
                    <br>
                    <canvas id="estadoSiniestroChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <div class="vehiculo-table-responsive">
                    <?php require_once("tablas_reporteria/estado_siniestro.php") ?>
                </div>
            </div>
        </div>
        <hr>
        <br>

        <!-- Gráfico y tabla de vehículos activos vs inactivos -->
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <h3>Vehículos Activos/Inactivos</h3>
                    <br>
                    <canvas id="vehiculosActivosChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <div class="vehiculo-table-responsive">
                    <?php require_once("tablas_reporteria/vehiculos_activos.php") ?>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


        <?php require_once("graficos_reporteria/siniestro_mes.php") ?>
        <?php require_once("graficos_reporteria/estado_siniestro.php") ?>
        <?php require_once("graficos_reporteria/vehiculos_activos.php") ?>
        <?php require_once("graficos_reporteria/choferes_sup.php") ?>

</body>

</html>