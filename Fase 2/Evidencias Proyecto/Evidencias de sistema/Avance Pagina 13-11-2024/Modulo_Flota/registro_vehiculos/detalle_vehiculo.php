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

    // Consulta para obtener el historial de kilometraje con el nombre del usuario
    $sql_km = "SELECT km, fecha_actualizacion, actualizado_por FROM km_historial WHERE patente = ? ORDER BY id desc limit 10";
    $stmt_km = $conexion->prepare($sql_km);
    $stmt_km->bind_param("s", $patente);
    $stmt_km->execute();
    $resultado_km = $stmt_km->get_result();
    $km_data = [];
    while ($row_km = $resultado_km->fetch_assoc()) {
        $km_data[] = $row_km;
    }

    // Consulta para obtener el historial de siniestros con costo
    $sql_siniestro = "
    SELECT s.id_siniestro, s.fecha, ts.estado, s.daño, s.costo
    FROM siniestro s
    LEFT JOIN tipo_siniestro ts ON s.id_tipo_siniestro = ts.id_tipo_siniestro
    WHERE s.patente = ?
    ORDER BY s.fecha DESC";

    $stmt_siniestro = $conexion->prepare($sql_siniestro);
    $stmt_siniestro->bind_param("s", $patente);
    $stmt_siniestro->execute();
    $resultado_siniestro = $stmt_siniestro->get_result();

    // Consulta para obtener las solicitudes de combustible
    $sql_combustible = "
    SELECT sc.fecha, sc.monto, u.nombre AS responsable, ua.nombre AS autorizador, sc.estado
    FROM solicitud_combustible sc
    LEFT JOIN usuario u ON sc.rut = u.rut
    LEFT JOIN usuario ua ON sc.rut_autorizador = ua.rut
    WHERE sc.patente = ?
    ORDER BY sc.fecha DESC";

    $stmt_combustible = $conexion->prepare($sql_combustible);
    $stmt_combustible->bind_param("s", $patente);
    $stmt_combustible->execute();
    $resultado_combustible = $stmt_combustible->get_result();

    // Consulta para obtener el historial de choferes
    $sql_historial_chofer = "
    SELECT u.nombre AS chofer, hc.fecha_inicio, hc.kilometraje_inicio, hc.fecha_termino, hc.kilometraje_termino
    FROM chofer_historial hc
    LEFT JOIN usuario u ON hc.rut_chofer = u.rut
    WHERE hc.patente = ?
    ORDER BY hc.fecha_inicio DESC";

    $stmt_historial_chofer = $conexion->prepare($sql_historial_chofer);
    $stmt_historial_chofer->bind_param("s", $patente);
    $stmt_historial_chofer->execute();
    $resultado_historial_chofer = $stmt_historial_chofer->get_result();
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
            <a class="elemento activo" href="">Detalles Vehiculo</a>
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
                <li><a class="dropdown-item" href="../actualizar_perfil/actualizar_perfil.php">Actualizar Perfil</a></li>
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
                            <th>Responsable actual</th>
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

            <!-- Otros Historiales (Kilometraje, Siniestros, Combustible) -->
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
                                            <td><?= (new DateTime($km['fecha_actualizacion']))->format('d/m/Y') ?></td>
                                            <td><?= number_format($km['km'], 0, ',', '.') . ' km' ?></td>
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
                    <canvas id="kmChart" width="400" height="200"></canvas>
                </div>
            </div>
            <hr>
            <br>


            <!-- Historial de Choferes -->
            <div class="col-md-12">
                <h4>Historial de Choferes</h4>
                <table class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Chofer</th>
                            <th>Fecha Inicio</th>
                            <th>Kilometraje Inicio</th>
                            <th>Fecha Término</th>
                            <th>Kilometraje Término</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultado_historial_chofer->num_rows > 0): ?>
                            <?php while ($historial = $resultado_historial_chofer->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($historial['chofer']) ?></td>
                                    <td><?= (new DateTime($historial['fecha_inicio']))->format('d/m/Y') ?></td>
                                    <td><?= number_format($historial['kilometraje_inicio'], 0, ',', '.') . ' km' ?></td>
                                    <td><?= $historial['fecha_termino'] ? (new DateTime($historial['fecha_termino']))->format('d/m/Y') : 'En curso' ?></td>
                                    <td><?= $historial['kilometraje_termino'] ? number_format($historial['kilometraje_termino'], 0, ',', '.') . ' Km' : 'En curso' ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No hay historial de choferes registrado para este vehículo.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <hr>
            <br>

            <!-- Historial Siniestros -->
            <div class="col-md-12">
                <h4>Historial Siniestros</h4>
                <div class="vehiculo-table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha Siniestro</th>
                                <th>Estado</th>
                                <th>Daño</th>
                                <th>Costo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($resultado_siniestro->num_rows > 0): ?>
                                <?php while ($siniestro = $resultado_siniestro->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= (new DateTime($siniestro['fecha']))->format('d/m/Y') ?></td>
                                        <td><?= htmlspecialchars($siniestro['estado']) ?></td>
                                        <td><?= htmlspecialchars($siniestro['daño']) ?></td>
                                        <td><?= '$' . number_format($siniestro['costo'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">No se ha registrado siniestro aún.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>

            <!-- Historial Combustible -->
            <div class="col-md-12">
                <h4>Historial Solicitud de Combustible</h4>
                <div class="vehiculo-table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha Solicitud</th>
                                <th>Monto</th>
                                <th>Estado Solicitud</th>
                                <th>Responsable</th>
                                <th>Autorizador</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($resultado_combustible->num_rows > 0): ?>
                                <?php while ($combustible = $resultado_combustible->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= (new DateTime($combustible['fecha']))->format('d/m/Y') ?></td>
                                        <td><?= '$' . number_format($combustible['monto'], 0, ',', '.') ?></td>
                                        <td class="text-center">
                                            <?= htmlspecialchars($combustible['estado']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($combustible['responsable']) ?></td>
                                        <td><?= htmlspecialchars($combustible['autorizador']) ?: '-' ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No se han registrado solicitudes de combustible para este vehículo.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
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
// Cerrar las consultas y la conexión
$stmt->close();
$stmt_km->close();
$stmt_historial_chofer->close();
$stmt_siniestro->close();
$stmt_combustible->close();
$conexion->close();
?>