<?php
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['rut'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../conexion.php");

// Consulta base para obtener el listado de siniestros
$sql_tabla_siniestro = "
    SELECT 
        s.id_siniestro, 
        s.patente, 
        v.marca, 
        v.modelo, 
        s.fecha, 
        ts.estado AS tipo_siniestro_estado, 
        s.daño, 
        s.costo
    FROM siniestro s
    LEFT JOIN vehiculo v ON s.patente = v.patente
    LEFT JOIN tipo_siniestro ts ON s.id_tipo_siniestro = ts.id_tipo_siniestro
";

// Filtrar siniestros según el rol del usuario
if ($_SESSION['rol'] == 3) {  // Si es chofer, solo ve sus propios siniestros
    $sql_tabla_siniestro .= " WHERE v.rut = '" . $_SESSION['rut'] . "'";
} elseif ($_SESSION['rol'] == 2) {  // Si es supervisor, ve siniestros de los choferes a su cargo
    $sql_tabla_siniestro .= "
        WHERE v.rut IN (
            SELECT u.rut
            FROM usuario u
            WHERE u.supervisor = '" . $_SESSION['rut'] . "'
        )
    ";
}

$sql_tabla_siniestro .= " ORDER BY s.id_siniestro DESC"; // Ordenar por id_siniestro descendente

$resultado = $conexion->query($sql_tabla_siniestro);

// Verificar si existen los parámetros de estado y mensaje en la URL
$status = isset($_GET['status']) ? $_GET['status'] : null;
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : null;
?>



<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Css -->
    <link rel="stylesheet" type="text/css" href="../estilos_generales/sidebar.css">
    <!--Bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <!-- Datatables -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link rel="shortcut icon" href="../img/logo.png" />
    <title>Modulo Flota | Siniestros</title>
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
            <h2>Listado de Siniestros</h2>
            <br>
            <div class="row mb-3">
                <table id="tabla_siniestros" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Numero Siniestro</th>
                            <th>Vehículo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($siniestro = $resultado->fetch_assoc()) : ?>
                            <tr>
                                <td><?= htmlspecialchars($siniestro['id_siniestro']) ?></td>
                                <td><?= htmlspecialchars($siniestro['patente']) . " / " . htmlspecialchars($siniestro['marca']) . " " . htmlspecialchars($siniestro['modelo']) ?></td>
                                <td>
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalSiniestro<?= htmlspecialchars($siniestro['id_siniestro']) ?>">
                                        Ver Detalles
                                    </button>

                                    <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2): ?>
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditar<?= htmlspecialchars($siniestro['id_siniestro']) ?>">
                                            Editar
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- Modal Detalles -->
                            <div class="modal fade" id="modalSiniestro<?= htmlspecialchars($siniestro['id_siniestro']) ?>" tabindex="-1" aria-labelledby="modalSiniestroLabel<?= htmlspecialchars($siniestro['id_siniestro']) ?>" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detalles del Siniestro #<?= htmlspecialchars($siniestro['id_siniestro']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Vehículo:</strong> <?= htmlspecialchars($siniestro['patente']) . " / " . htmlspecialchars($siniestro['marca']) . " " . htmlspecialchars($siniestro['modelo']) ?></p>
                                            <p><strong>Fecha:</strong> <?= $siniestro['fecha'] ? (new DateTime($siniestro['fecha']))->format('d/m/Y') : '' ?></p>
                                            <p><strong>Estado del siniestro:</strong> <?= htmlspecialchars($siniestro['tipo_siniestro_estado']) ?></p>
                                            <p><strong>Daño:</strong> <?= htmlspecialchars($siniestro['daño']) ?></p>
                                            <p><strong>Costo:</strong>
                                                <?php
                                                if ($siniestro['costo'] == 0) {
                                                    echo 'Sin registro';
                                                } else {
                                                    echo '$' . number_format($siniestro['costo'], 0, ',', '.') . ' CLP';
                                                }
                                                ?>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Editar -->
                            <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2): ?>
                                <div class="modal fade" id="modalEditar<?= htmlspecialchars($siniestro['id_siniestro']) ?>" tabindex="-1" aria-labelledby="modalEditarLabel<?= htmlspecialchars($siniestro['id_siniestro']) ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Editar Siniestro #<?= htmlspecialchars($siniestro['id_siniestro']) ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="php/editar_siniestro.php" method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_siniestro" value="<?= htmlspecialchars($siniestro['id_siniestro']) ?>">

                                                    <div class="mb-3">
                                                        <label for="estado" class="form-label">Estado del Siniestro</label>
                                                        <select class="form-select" name="id_tipo_siniestro" required>
                                                            <option value="1" <?= $siniestro['tipo_siniestro_estado'] == 'Reparado' ? 'selected' : '' ?>>Reparado</option>
                                                            <option value="2" <?= $siniestro['tipo_siniestro_estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                                            <option value="3" <?= $siniestro['tipo_siniestro_estado'] == 'En Reparación' ? 'selected' : '' ?>>En Reparación</option>
                                                            <option value="4" <?= $siniestro['tipo_siniestro_estado'] == 'Pérdida Total' ? 'selected' : '' ?>>Pérdida Total</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="costo" class="form-label">Costo del Siniestro</label>
                                                        <input type="number" class="form-control" name="costo"
                                                            value="<?= $siniestro['costo'] > 0 ? intval($siniestro['costo']) : '' ?>"
                                                            min="0" placeholder="Ingrese el costo en CLP">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            // Mostrar alerta con SweetAlert si hay parámetros de estado y mensaje
            <?php if ($status && $mensaje): ?>
                Swal.fire({
                    icon: '<?= $status ?>',
                    title: 'Resultado',
                    text: '<?= $mensaje ?>',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>

            $(document).ready(function() {
                $('#tabla_siniestros').DataTable({
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-CL.json',
                    },
                    order: [
                        [0, 'desc'] // Ordenar por el número de siniestro en orden descendente
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