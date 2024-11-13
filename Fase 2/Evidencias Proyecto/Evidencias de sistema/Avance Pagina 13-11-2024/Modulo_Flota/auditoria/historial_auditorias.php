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
    SELECT a.id_auditoria, a.patente, DATE_FORMAT(a.fecha, '%d/%m/%Y') AS fecha, a.estado, u.nombre AS chofer
    FROM auditoria a
    JOIN usuario u ON a.rut_responsable = u.rut
    WHERE u.supervisor = ? OR ? = 1
    ORDER BY a.fecha DESC"; // Si es admin (rol = 1), puede ver todas las auditorías

$stmt = $conexion->prepare($sql_auditorias);

// Si el usuario no es admin, vinculamos el parámetro supervisor
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
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <!-- DataTables -->
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

        <table id="tabla_auditorias" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Patente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Chofer</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado_auditorias && $resultado_auditorias->num_rows > 0): ?>
                    <?php while ($auditoria = $resultado_auditorias->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($auditoria['patente']) ?></td>
                            <td><?= htmlspecialchars($auditoria['fecha']) ?></td>
                            <td><?= htmlspecialchars($auditoria['estado']) ?></td>
                            <td><?= htmlspecialchars($auditoria['chofer']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No se encontraron auditorías.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <script>
        $(document).ready(function() {
            $('#tabla_auditorias').DataTable({
                "order": [[1, "desc"]] // Ordena la tabla por la columna de Fecha (índice 1) en orden descendente
            });
        });
    </script>
</body>

</html>
