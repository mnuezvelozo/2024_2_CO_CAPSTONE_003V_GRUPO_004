<?php
include("../../conexion.php");
session_start();

try {
    // Obtener los datos del formulario
    $patente = $_POST['patente'];
    $kilometraje_actual = $_POST['kilometraje_actual'];
    $monto_solicitado = $_POST['monto_solicitado'];
    $rut = $_SESSION['rut'];  // El chofer que está creando la solicitud

    // Validaciones
    if (empty($patente) || empty($kilometraje_actual) || empty($monto_solicitado)) {
        throw new Exception("Todos los campos son obligatorios.");
    }

    // Iniciar una transacción
    $conexion->begin_transaction();

    // Insertar en la tabla de solicitud_combustible
    $sql_solicitud = "INSERT INTO solicitud_combustible (patente, rut, kilometraje, fecha, monto, estado)
                      VALUES (?, ?, ?, CURDATE(), ?, 'Pendiente')";
    $stmt_solicitud = $conexion->prepare($sql_solicitud);
    $stmt_solicitud->bind_param("ssis", $patente, $rut, $kilometraje_actual, $monto_solicitado);
    $stmt_solicitud->execute();

    if ($stmt_solicitud->affected_rows > 0) {
        // Actualizar el km_actual en la tabla de vehiculo
        $sql_update_km = "UPDATE vehiculo SET km_actual = ? WHERE patente = ?";
        $stmt_update_km = $conexion->prepare($sql_update_km);
        $stmt_update_km->bind_param("is", $kilometraje_actual, $patente);
        $stmt_update_km->execute();

        if ($stmt_update_km->affected_rows > 0) {
            // Confirmar la transacción solo con la solicitud de combustible y km_actual actualizados
            $conexion->commit();
            $mensaje = "Solicitud creada exitosamente.";
            $icono = "success";
        } else {
            // Revertir la transacción si el km_actual no se actualizó
            $conexion->rollback();
            throw new Exception("Error al actualizar el kilometraje actual del vehículo.");
        }
    } else {
        // Revertir la transacción si la solicitud no se insertó
        $conexion->rollback();
        throw new Exception("Error al crear la solicitud de combustible.");
    }
} catch (Exception $e) {
    $mensaje = "Error: " . $e->getMessage();
    $icono = "error";
}

// Redirigir a la página principal con mensaje de éxito o error
header("Location: ../lista_vista_chofer.php?status=$icono&mensaje=$mensaje");
exit();
?>
