<?php
// Incluir la conexión a la base de datos
include('../conexion.php');

// Verificar si se ha enviado la patente por GET
if (isset($_GET['patente'])) {
    $patente = $_GET['patente'];

    // Consulta para obtener los detalles del vehículo
    $sql = "SELECT v.patente, v.marca, v.modelo, v.año, u.nombre, u.rut
            FROM vehiculo v
            LEFT JOIN usuario u ON v.rut = u.rut
            WHERE v.patente = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $patente);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificar si se encontró el vehículo
    if ($resultado->num_rows > 0) {
        $vehiculo = $resultado->fetch_assoc();
    } else {
        echo "No se encontraron detalles para este vehículo.";
        exit();
    }

    // Consulta para obtener el historial de kilometraje
    $sql_km = "SELECT km, fecha_actualizacion, actualizado_por FROM km_historial WHERE patente = ? ORDER BY id desc limit 100";
    $stmt_km = $conexion->prepare($sql_km);
    $stmt_km->bind_param("s", $patente);
    $stmt_km->execute();
    $resultado_km = $stmt_km->get_result();
    $km_data = [];
    while ($row_km = $resultado_km->fetch_assoc()) {
        $km_data[] = $row_km;
    }

    // Consulta para obtener el historial de siniestros
    $sql_siniestro = "
        SELECT s.fecha, ts.estado, u.nombre
        FROM siniestro s 
        LEFT JOIN tipo_siniestro ts ON s.id_tipo_siniestro = ts.id_tipo_siniestro 
        LEFT JOIN usuario u ON u.rut = s.rut
        WHERE s.patente = ?
        ORDER BY s.fecha DESC";

    $stmt_siniestro = $conexion->prepare($sql_siniestro);
    $stmt_siniestro->bind_param("s", $patente);
    $stmt_siniestro->execute();
    $resultado_siniestro = $stmt_siniestro->get_result();
} else {
    echo "No se proporcionó una patente válida.";
    exit();
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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Datatables -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link rel="shortcut icon" href="../img/logo.png" />
    <title>Modulo Flota | Detalles</title>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="cuadricula">
            <a href="">
                <img src="../img/logo.png" alt="Logo" class="logo_Blanco">
            </a>
            <hr class="sidebarHr">
            <a class="elemento activo" href="">Personal</a>
            <a class="elemento sub" href="../registro_vehiculos/vehiculos.php">⏪ Regresar</a>
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
            <h3>Detalles del Vehículo</h3>
            <br>
            <div class="row mb-3">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Patente</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Año</th>
                            <th>Responsable</th>
                            <th>Rut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= htmlspecialchars($vehiculo['patente']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['marca']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['modelo']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['año']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['nombre']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['rut']) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr>

            <div>
                <!-- Historial Km y Gráfico -->
                <div class="row">
                    <div class="col-md-6">
                        <h4>Historial Kilometraje</h4>
                        <div class="vehiculo-table-responsive">
                            <table class="table table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Kilometraje</th>
                                        <th>Actualizado por</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($km_data) > 0): ?>
                                        <?php foreach ($km_data as $km): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($km['fecha_actualizacion']) ?></td>
                                                <td><?= htmlspecialchars($km['km']) ?> Km</td>
                                                <td><?= htmlspecialchars($km['actualizado_por']) ?: 'Sin Registro' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3">No se ha registrado kilometraje aún.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4>Gráfico de Kilometraje</h4>
                        <!-- Canvas para el gráfico de historial de km -->
                        <canvas id="kmChart" width="400" height="200"></canvas>
                    </div>
                </div>
                <hr>

                <!-- Historial Siniestros -->
                <div class="col-md-13">
                    <h4>Historial Siniestros</h4>
                    <br>
                    <div class="vehiculo-table-responsive vehiculo-small-table">
                        <table class="table table-striped table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Fecha Siniestro</th>
                                    <th>Estado</th>
                                    <th>Responsable</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($resultado_siniestro->num_rows > 0): ?>
                                    <?php while ($siniestro = $resultado_siniestro->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($siniestro['fecha']) ?></td>
                                            <td><?= htmlspecialchars($siniestro['estado']) ?></td>
                                            <td><?= htmlspecialchars($siniestro['nombre']) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3">No se ha registrado siniestro aún.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>

                <!-- Historial Siniestros -->
                <div class="col-md-13">
                    <h4>Historial Siniestros</h4>
                    <br>
                    <div class="vehiculo-table-responsive vehiculo-small-table">
                        <table class="table table-striped table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>fecha solicitud</th>
                                    <th>monto</th>
                                    <th>Responsable</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>24-09-2024</td>
                                    <td>25.000</td>
                                    <td>Michael Nuñez Velozo</td>
                                </tr>
                                <tr>
                                    <td>24-09-2024</td>
                                    <td>20.000</td>
                                    <td>Matias Quiñones Varela</td>
                                </tr>
                                <tr>
                                    <td>24-09-2024</td>
                                    <td>25.000</td>
                                    <td>Joaquin Flores Rodriguez</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                                <!-- termina las tablas -->
            </div>
        </div>
    </main>

    <script>
        // Datos para el gráfico de historial de km
        var kmData = {
            labels: [<?php foreach ($km_data as $km) {
                            echo "'" . $km['fecha_actualizacion'] . "',";
                        } ?>],
            datasets: [{
                label: 'Kilometraje',
                data: [<?php foreach ($km_data as $km) {
                            echo $km['km'] . ",";
                        } ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        var ctxKm = document.getElementById('kmChart').getContext('2d');
        new Chart(ctxKm, {
            type: 'line',
            data: kmData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>

<?php
$stmt->close();
$stmt_km->close();
$conexion->close();
?>