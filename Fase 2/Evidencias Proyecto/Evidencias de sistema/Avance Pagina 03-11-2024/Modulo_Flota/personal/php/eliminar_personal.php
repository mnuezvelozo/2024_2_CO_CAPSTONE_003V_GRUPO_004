<?php
include("../../conexion.php");
session_start();

try {
    $rut = $_POST['rut'];

    // Validar que el RUT no esté vacío
    if (empty($rut)) {
        throw new Exception("El RUT del usuario es obligatorio para desactivar.");
    }

    // Obtener la fecha actual en el formato 'YYYY/MM/DD'
    $fecha_termino = date('Y/m/d');

    // Consulta SQL para desactivar el usuario, vaciar los campos y agregar la fecha de término
    $sql_actualizar = "UPDATE usuario 
        SET activo = 'No', 
            Usuario = NULL, 
            clave = NULL, 
            Id_Rol = NULL,
            id_cargo = NULL, 
            supervisor = NULL, 
            fecha_termino = ? 
        WHERE rut = ?";

    $stmt_actualizar = mysqli_prepare($conexion, $sql_actualizar);
    mysqli_stmt_bind_param($stmt_actualizar, "ss", $fecha_termino, $rut);
    mysqli_stmt_execute($stmt_actualizar);

    if (mysqli_stmt_affected_rows($stmt_actualizar) > 0) {
        $icono = "success";
        $mensaje = "Usuario desactivado, campos eliminados y fecha de término registrada correctamente.";
    } else {
        throw new Exception("No se pudo desactivar el usuario. Verifique el RUT.");
    }

    mysqli_stmt_close($stmt_actualizar);
} catch (Exception $e) {
    $icono = "error";
    $mensaje = "Hubo un error al desactivar y eliminar campos: " . $e->getMessage();
}

// Redirigir de nuevo a la página principal con el estado y el mensaje
header("Location: ../lista_empleados.php?status=$icono&mensaje=$mensaje");
exit();
?>
