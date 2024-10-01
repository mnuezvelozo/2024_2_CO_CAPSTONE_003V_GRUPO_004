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

    // Insertar en la base de datos
    $sql = "INSERT INTO solicitud_combustible (patente, rut, kilometraje, fecha, monto, estado)
            VALUES (?, ?, ?, CURDATE(), ?, 'Pendiente')";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssis", $patente, $rut, $kilometraje_actual, $monto_solicitado);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $mensaje = "Solicitud creada exitosamente.";
        $icono = "success";
    } else {
        throw new Exception("Error al crear la solicitud.");
    }
} catch (Exception $e) {
    $mensaje = "Error: " . $e->getMessage();
    $icono = "error";
}

// Redirigir a la página principal con mensaje de éxito o error
header("Location: ../lista_solicitud.php?status=$icono&mensaje=$mensaje");
exit();

