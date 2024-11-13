<?php
session_start();
include('../../conexion.php'); // Asegúrate de que la ruta sea correcta

if (!isset($_GET['id'])) {
    echo "ID de auditoría no proporcionado.";
    exit();
}

$id_auditoria = $_GET['id'];

// Consulta para obtener los detalles de la auditoría
$query = "SELECT * FROM auditoria WHERE id_auditoria = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_auditoria);
$stmt->execute();
$result = $stmt->get_result();
$auditoria = $result->fetch_assoc();

if (!$auditoria) {
    echo "Auditoría no encontrada.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../img/logo.png" />
    <title>Completar Auditoría</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../estilos_generales/sidebar.css">
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="cuadricula">
            <a href="">
                <img src="../../img/logo.png" alt="Logo" class="logo_Blanco">
            </a>
            <hr class="sidebarHr">
            <a class="elemento activo" href="../auditoria_pendientes.php">Auditoría</a>
            <a class="elemento sub" href="../../index.php">⏪ Regresar</a>
        </div>

        <!-- Dropdown Menú -->
        <div class="dropdown">
            <hr class="sidebarHr">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../../img/logo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong><?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Usuario'; ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu text-small shadow">
                <li><a class="dropdown-item" href="../../actualizar_perfil/actualizar_perfil.php">Actualizar Perfil</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="/modulo_flota/login/cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="content">
        <div class="container mt-5">
            <h1 class="mb-4">Completar Auditoría para el vehículo <?php echo htmlspecialchars($auditoria['patente']); ?></h1>
            <form action="guardar_auditoria.php" method="POST">
                <!-- Campo oculto para enviar id_auditoria -->
                <input type="hidden" name="id_auditoria" value="<?php echo htmlspecialchars($id_auditoria); ?>">

                <div class="mb-3">
                    <label for="danos" class="form-label">¿Hay daños visibles en la carrocería?</label>
                    <select id="danos" name="danos" class="form-select" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="documentos" class="form-label">¿El vehículo tiene los documentos necesarios?</label>
                    <select id="documentos" name="documentos" class="form-select" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="funcionamiento" class="form-label">¿Funcionan correctamente las luces y frenos?</label>
                    <select id="funcionamiento" name="funcionamiento" class="form-select" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Guardar Auditoría</button>
            </form>
        </div>
    </main>
</body>

</html>

<?php
$stmt->close();
$conexion->close();
?>
