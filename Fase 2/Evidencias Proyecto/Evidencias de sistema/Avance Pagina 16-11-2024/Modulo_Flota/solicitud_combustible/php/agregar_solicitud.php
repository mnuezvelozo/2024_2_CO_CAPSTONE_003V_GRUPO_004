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
        // Confirmar la transacción solo con la solicitud de combustible creada
        $conexion->commit();
        $mensaje = "Solicitud creada exitosamente y pendiente de aprobación.";
        $icono = "success";
    } else {
        // Revertir la transacción si la solicitud no se insertó
        $conexion->rollback();
        throw new Exception("Error al crear la solicitud de combustible.");
    }
} catch (Exception $e) {
    $conexion->rollback();
    $mensaje = "Error: " . $e->getMessage();
    $icono = "error";
}

// Redirigir a la página principal con mensaje de éxito o error
header("Location: ../../index.php?status=$icono&mensaje=$mensaje");
exit();
?>
