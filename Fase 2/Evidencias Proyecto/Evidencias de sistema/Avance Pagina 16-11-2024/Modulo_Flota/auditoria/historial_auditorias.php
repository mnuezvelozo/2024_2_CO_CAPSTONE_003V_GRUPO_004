<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['rut'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../conexion.php");

// Obtener el rut y rol del usuario actual
$rut_usuario = $_SESSION['rut'];
$rol_usuario = $_SESSION['rol']; // Asumiendo que tienes esta variable en la sesión

// Consulta para obtener el historial de auditorías
$sql_auditorias = "
    SELECT 
        a.id_auditoria, 
        a.patente, 
        DATE_FORMAT(a.fecha, '%d/%m/%Y') AS fecha, 
        a.estado, 
        u.nombre AS chofer,
        a.danos,
        a.documentos,
        a.funcionamiento,
        a.observaciones
    FROM auditoria a
    JOIN usuario u ON a.rut_responsable = u.rut
    WHERE u.supervisor = ? OR ? = 1
    ORDER BY a.fecha DESC";

$stmt = $conexion->prepare($sql_auditorias);
$stmt->bind_param('si', $rut_usuario, $rol_usuario);
$stmt->execute();
$resultado_auditorias = $stmt->get_result();
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
    <title>Modulo Flota | Historial de Auditorías</title>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="cuadricula">
            <a href="">
                <img src="../img/logo.png" alt="Logo" class="logo_Blanco">
            </a>
            <hr class="sidebarHr">
            <a class="elemento activo" href="historial_auditorias.php">Historial de Auditoría</a>
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
                <li><a class="dropdown-item" href="../login/cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Historial de Auditorías</h1>
        </div>

        <table id="tabla_auditorias" class="table table-striped">
            <thead>
                <tr>
                    <th>Patente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Chofer</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($auditoria = $resultado_auditorias->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($auditoria['patente']) ?></td>
                        <td><?= htmlspecialchars($auditoria['fecha']) ?></td>
                        <td><?= htmlspecialchars($auditoria['estado']) ?></td>
                        <td><?= htmlspecialchars($auditoria['chofer']) ?></td>
                        <td>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAuditoria<?= htmlspecialchars($auditoria['id_auditoria']) ?>">
                                Ver Detalles
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Detalles -->
                    <div class="modal fade" id="modalAuditoria<?= htmlspecialchars($auditoria['id_auditoria']) ?>" tabindex="-1" aria-labelledby="modalAuditoriaLabel<?= htmlspecialchars($auditoria['id_auditoria']) ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detalles de la Auditoría #<?= htmlspecialchars($auditoria['id_auditoria']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Estado de la auditoría:</strong> <?= htmlspecialchars($auditoria['estado']) ?></p>
                                    <p><strong>Daños visibles:</strong> <?= $auditoria['danos'] ? htmlspecialchars($auditoria['danos']) : 'Sin registro' ?></p>
                                    <p><strong>Documentos necesarios:</strong> <?= $auditoria['documentos'] ? htmlspecialchars($auditoria['documentos']) : 'Sin registro' ?></p>
                                    <p><strong>Buen funcionamiento de luces/frenos:</strong> <?= $auditoria['funcionamiento'] ? htmlspecialchars($auditoria['funcionamiento']) : 'Sin registro' ?></p>
                                    <p><strong>Observaciones:</strong> <?= $auditoria['observaciones'] ? htmlspecialchars($auditoria['observaciones']) : 'Sin observaciones' ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>

<script>
    $(document).ready(function() {
        $('#tabla_auditorias').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-CL.json',
            },
            order: [
                [0, 'desc']
            ]
        });
    });
</script>