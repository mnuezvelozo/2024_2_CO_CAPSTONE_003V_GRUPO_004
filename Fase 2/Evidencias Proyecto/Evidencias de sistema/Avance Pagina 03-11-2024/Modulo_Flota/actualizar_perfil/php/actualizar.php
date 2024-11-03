<?php
include("../../conexion.php");
session_start();

try {
    $rut = $_POST['rut_usuario'];
    $nombre = $_POST['username'];
    $new_password = $_POST['new_password']; // Nueva contraseña (si aplica)

    // Validaciones
    if (strlen($nombre) > 20) {
        throw new Exception("El nombre de usuario no debe exceder los 20 caracteres.");
    }

    // Si se ha proporcionado una nueva contraseña
    if (!empty($new_password)) {
        if (strlen($new_password) < 8) {
            throw new Exception("La contraseña debe tener al menos 8 caracteres.");
        }

        if (!preg_match('/[A-Z]/', $new_password)) {
            throw new Exception("La contraseña debe contener al menos una letra mayúscula.");
        }

        if (!preg_match('/[0-9]/', $new_password)) {
            throw new Exception("La contraseña debe contener al menos un número.");
        }

        // Encriptar la nueva contraseña y actualizar el usuario
        $hashed_password = hash('sha256', $new_password); // Encriptar con SHA-256
        $sql_actualizar = " UPDATE `modulo_flota`.`usuario` 
                            SET `Usuario` = ?, `clave` = ?
                            WHERE `rut` = ?";

        $stmnt_actualizar = mysqli_prepare($conexion, $sql_actualizar);
        $stmnt_actualizar->bind_param("sss", $nombre, $hashed_password, $rut);
    } else {
        // Si no se cambia la contraseña, actualizar solo el nombre de usuario
        $sql_actualizar = "
            UPDATE `modulo_flota`.`usuario` 
            SET `Usuario` = ?
            WHERE `rut` = ?";

        $stmnt_actualizar = mysqli_prepare($conexion, $sql_actualizar);
        $stmnt_actualizar->bind_param("ss", $nombre, $rut);
    }

    // Ejecutar la consulta
    mysqli_stmt_execute($stmnt_actualizar);

    // Actualizar la sesión con los nuevos datos
    //$_SESSION['Nombre'] = $nombre; // Actualizar el nombre de usuario en la sesión

    $icono = "success";
    $mensaje = "Actualización exitosa.";
} catch (Exception $e) {
    $icono = "error";
    $mensaje = "Hubo un error al actualizar: " . $e->getMessage();
}

// Redirigir con éxito a la página de actualización
header("Location: ../actualizar_perfil.php?status=$icono&mensaje=$mensaje");
exit();
?>
