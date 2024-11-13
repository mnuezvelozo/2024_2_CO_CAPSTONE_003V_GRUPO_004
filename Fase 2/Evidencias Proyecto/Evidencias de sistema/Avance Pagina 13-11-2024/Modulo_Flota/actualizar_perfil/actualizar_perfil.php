<?php
include("../conexion.php");
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['rut'])) {
    header("Location: ../login/login.php");
    exit();
}

// Verifica los roles permitidos
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 && $_SESSION['rol'] != 3) {
    header("Location: ../index.php?error=No tienes permisos para acceder a esta página.");
    exit();
}

// Consulta para obtener el nombre de usuario desde la base de datos
$rut = $_SESSION['rut'];
$query = "SELECT Usuario FROM usuario WHERE rut = '$rut'";
$result = mysqli_query($conexion, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $usuario = $row['Usuario'];
} else {
    $usuario = '';
}
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
    <title>Modulo Flota | Actualización</title>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="cuadricula">
            <a href="">
                <img src="../img/logo.png" alt="Logo" class="logo_Blanco">
            </a>
            <hr class="sidebarHr">
            <a class="elemento activo" href=""> Actualización Perfil </a>
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
                <li><a class="dropdown-item" href="">Actualizar Perfil</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="/modulo_flota/login/cerrar_sesion.php">Cerrar Sesión</a></li>

            </ul>
        </div>
    </nav>

    <main class="content">
        <h1 class="text-center">Actualizar Perfil</h1>
        <form action="php/actualizar.php" method="POST">
            <div class="mb-3">
                <label for="input_rut">Rut</label>
                <!-- Campo RUT no editable -->
                <input type="text" name="rut_usuario" id="input_rut" class="form-control" value="<?php echo $rut; ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="input_usuario_actualizar">Usuario</label>
                <!-- Campo Usuario editable -->
                <input type="text" name="username" id="input_usuario_actualizar" class="form-control" value="<?php echo $usuario; ?>" required>
            </div>

            <div class="mb-3">
                <label for="input_password_actualizar">Nueva Contraseña (Opcional)</label>
                <div class="input-group position-relative">
                    <input type="password" name="new_password" id="input_password_actualizar" class="form-control" placeholder="Dejar en blanco para no cambiar">
                    <span class="position-absolute eye-icon" onclick="togglePasswordVisibility()">
                        <i id="eyeIcon" class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="password-recommendations">
                <p><strong>La contraseña debe:</strong></p>
                <ul>
                    <li>Tener más de 8 caracteres</li>
                    <li>Contener al menos una letra mayúscula</li>
                    <li>Contener al menos un número</li>
                </ul>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </main>

    <!-- Mostrar la alerta si hay un estado de actualización -->
    <?php
    // Verifica si existen los parámetros status y mensaje en la URL
    if (isset($_GET['status']) && isset($_GET['mensaje'])) {
        $status = htmlspecialchars($_GET['status']);
        $mensaje = htmlspecialchars($_GET['mensaje']);
    }
    ?>

    <script>
        // Función para alternar visibilidad de la contraseña
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('input_password_actualizar');
            var eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Si los parámetros existen, muestra la alerta
            <?php if (isset($status) && isset($mensaje)) { ?>
                Swal.fire({
                    icon: '<?= $status ?>', // success o error
                    title: '<?= $mensaje ?>',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    timer: 3000
                });
            <?php } ?>
        });
    </script>

    <style>
        .input-group.position-relative input {
            padding-right: 40px;
            /* Añadimos espacio para el icono */
        }

        .eye-icon {
            position: absolute;
            right: 10px;
            top: 41.5%;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 10;
            /* Asegura que el ícono esté siempre visible */
        }

        .eye-icon i {
            font-size: 18px;
            /* Ajustar el tamaño del ícono */
        }

        /* Recomendaciones de contraseña */
        .password-recommendations {
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
        }

        .password-recommendations p {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .password-recommendations ul {
            padding-left: 20px;
            margin-bottom: 0;
        }

        .password-recommendations ul li {
            margin-bottom: 5px;
            font-size: 14px;
        }
    </style>

</html>