<?php
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['rut'])) {
    header("Location: ../login/login.php");
    exit();
}

// Solo admin, supervisores y choferes pueden acceder a esta página
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 && $_SESSION['rol'] != 3) {
    header("Location: ../index.php?error=No tienes permisos para acceder a esta página.");
    exit();
}

// Conexión a la base de datos
include("../conexion.php");

// Consulta para obtener los gastos de combustible por mes y año
$sql_combustible = "
    SELECT 
        MONTH(fecha) AS mes, 
        YEAR(fecha) AS año, 
        SUM(monto) AS total_monto 
    FROM solicitud_combustible 
    WHERE estado = 'Aprobada'
    GROUP BY mes, año
    ORDER BY año DESC, mes";
$result_combustible = $conexion->query($sql_combustible);

// Consulta para obtener los costos de siniestros por mes y año
$sql_siniestros = "
    SELECT 
        MONTH(fecha) AS mes, 
        YEAR(fecha) AS año, 
        SUM(costo) AS total_costo 
    FROM siniestro 
    WHERE costo > 0
    GROUP BY mes, año
    ORDER BY año DESC, mes";
$result_siniestros = $conexion->query($sql_siniestros);

// Total de gastos de combustible y siniestros
$total_combustible = $conexion->query("SELECT SUM(monto) AS total FROM solicitud_combustible WHERE estado = 'Aprobada'")->fetch_assoc()['total'];
$total_siniestros = $conexion->query("SELECT SUM(costo) AS total FROM siniestro WHERE costo > 0")->fetch_assoc()['total'];
$total_gastos = $total_combustible + $total_siniestros;
$porcentaje_combustible = $total_gastos > 0 ? ($total_combustible / $total_gastos) * 100 : 0;
$porcentaje_siniestros = $total_gastos > 0 ? ($total_siniestros / $total_gastos) * 100 : 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/logo.png" />
    <title>Control de Dinero | Flota</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Estilos generales -->
    <link rel="stylesheet" href="../estilos_generales/sidebar.css">
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="cuadricula">
            <a href="../index.php">
                <img src="../img/logo.png" alt="Logo" class="logo_Blanco">
            </a>
            <hr class="sidebarHr">
            <a class="elemento activo" href="">Control de Dinero</a>
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

    <!-- Contenido principal -->
    <main class="content p-4">
        <h1 class="mb-4">Control de Dinero de la Flota</h1>

        <!-- Contenedor de gráficos con más separación -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card p-3">
                    <canvas id="gastoMensualChart"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <canvas id="gastoCircularChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabla de gastos -->
        <div class="row mb-4">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th>Año</th>
                            <th>Total Gastos de Combustible</th>
                            <th>Total Costos de Siniestros</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result_combustible->data_seek(0);
                        $result_siniestros->data_seek(0);

                        while ($row_combustible = $result_combustible->fetch_assoc()) {
                            $row_siniestro = $result_siniestros->fetch_assoc();
                            echo '<tr>';
                            echo '<td>' . $row_combustible['mes'] . '</td>';
                            echo '<td>' . $row_combustible['año'] . '</td>';
                            echo '<td>$' . number_format($row_combustible['total_monto'], 0, ',', '.') . '</td>';
                            echo '<td>$' . number_format($row_siniestro['total_costo'], 0, ',', '.') . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Script para gráficos -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gráfico de barras de gastos mensuales
            var ctxBar = document.getElementById('gastoMensualChart').getContext('2d');
            var gastoMensualChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: [
                        <?php
                        $labels = [];
                        $data_combustible = [];
                        $data_siniestros = [];

                        $result_combustible->data_seek(0);
                        $result_siniestros->data_seek(0);

                        while ($row_combustible = $result_combustible->fetch_assoc()) {
                            $row_siniestro = $result_siniestros->fetch_assoc();
                            $labels[] = "'Mes " . $row_combustible['mes'] . " - " . $row_combustible['año'] . "'";
                            $data_combustible[] = $row_combustible['total_monto'];
                            $data_siniestros[] = $row_siniestro['total_costo'];
                        }

                        echo implode(',', $labels);
                        ?>
                    ],
                    datasets: [{
                        label: 'Gastos de Combustible',
                        data: [<?= implode(',', $data_combustible) ?>],
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Costos de Siniestros',
                        data: [<?= implode(',', $data_siniestros) ?>],
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Gráfico circular de porcentajes
            var ctxDoughnut = document.getElementById('gastoCircularChart').getContext('2d');
            var gastoCircularChart = new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: ['Combustible', 'Siniestros'],
                    datasets: [{
                        data: [<?= $porcentaje_combustible ?>, <?= $porcentaje_siniestros ?>],
                        backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(255, 99, 132, 0.6)'],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2) + '%';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>

<?php
$conexion->close();
?>