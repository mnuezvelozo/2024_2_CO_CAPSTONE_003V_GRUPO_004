<?php
include("../../conexion.php");
session_start();

try {
    $patente = $_POST['patente'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $año = $_POST['año'];
    $km_actual = $_POST['km_actual'];
    $revision_tecnica = $_POST['fecha_revision_tecnica'];
    $encargado = $_POST['rut'];
    $actualizado_por = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Desconocido'; // Aquí usamos $_SESSION['nombre']

    // Validaciones del lado del servidor
    if (!is_numeric($año) || strlen($año) != 4 || $año < 1990 || $año > 3000) {
        throw new Exception("El año debe ser un número de 4 dígitos entre 1990 y 3000.");
    }

    if (!is_numeric($km_actual) || $km_actual < 0) {
        throw new Exception("El kilometraje debe ser un número positivo.");
    }

    if (empty($encargado)) {
        $encargado = NULL;
    }

    // Obtener el kilometraje actual desde la base de datos
    $sql_select = "SELECT km_actual FROM vehiculo WHERE patente = ?";
    $stmnt_select = mysqli_prepare($conexion, $sql_select);
    mysqli_stmt_bind_param($stmnt_select, "s", $patente);
    mysqli_stmt_execute($stmnt_select);
    mysqli_stmt_bind_result($stmnt_select, $km_actual_bd);
    mysqli_stmt_fetch($stmnt_select);
    mysqli_stmt_close($stmnt_select);

    // Verificar si el kilometraje ingresado es menor al almacenado
    if ($km_actual < $km_actual_bd) {
        throw new Exception("El kilometraje ingresado no puede ser menor al kilometraje actual registrado ($km_actual_bd km).");
    }

    // Iniciar transacción para asegurarnos de que ambas operaciones ocurren juntas
    mysqli_begin_transaction($conexion);

    // Consulta SQL para actualizar los datos del vehículo (incluido el km_actual)
    $sql_actualizar = "
        UPDATE vehiculo 
        SET marca = ?, 
            modelo = ?, 
            año = ?, 
            km_actual = ?, 
            fecha_revision_tecnica = ?, 
            rut = ?
        WHERE patente = ?";

    $stmnt_actualizar = mysqli_prepare($conexion, $sql_actualizar);
    mysqli_stmt_bind_param($stmnt_actualizar, "ssiisss", $marca, $modelo, $año, $km_actual, $revision_tecnica, $encargado, $patente);
    mysqli_stmt_execute($stmnt_actualizar);

    if (mysqli_stmt_affected_rows($stmnt_actualizar) > 0) {
        // Si la actualización fue exitosa, también insertar en la tabla `km_historial`
        $sql_insert_historial = "INSERT INTO km_historial (patente, km, fecha_actualizacion, actualizado_por) 
                                 VALUES (?, ?, NOW(), ?)";
        $stmnt_historial = mysqli_prepare($conexion, $sql_insert_historial);
        mysqli_stmt_bind_param($stmnt_historial, "sis", $patente, $km_actual, $actualizado_por);
        mysqli_stmt_execute($stmnt_historial);

        if (mysqli_stmt_affected_rows($stmnt_historial) > 0) {
            // Confirmar la transacción si ambas operaciones son exitosas
            mysqli_commit($conexion);
            $icono = "success";
            $mensaje = "Actualización exitosa.";
        } else {
            // Si la inserción en `km_historial` falla, deshacer la transacción
            mysqli_rollback($conexion);
            throw new Exception("Error al insertar el historial de kilometraje.");
        }
    } else {
        throw new Exception("No se realizaron cambios en los datos del vehículo.");
    }

    mysqli_stmt_close($stmnt_actualizar);
    mysqli_stmt_close($stmnt_historial);
} catch (Exception $e) {
    mysqli_rollback($conexion); // En caso de error, deshacer la transacción
    $icono = "error";
    $mensaje = "Hubo un error al actualizar: " . $e->getMessage();
}

// Redirigir de nuevo a la página principal con el estado y el mensaje
header("Location: ../vehiculos.php?status=$icono&mensaje=$mensaje");
exit();
?>
