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
    $nuevo_encargado = $_POST['rut'];
    $actualizado_por = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Desconocido';

    // Obtener el encargado actual del vehículo
    $sql_select = "SELECT rut FROM vehiculo WHERE patente = ?";
    $stmt_select = $conexion->prepare($sql_select);
    $stmt_select->bind_param("s", $patente);
    $stmt_select->execute();
    $stmt_select->bind_result($rut_actual);
    $stmt_select->fetch();
    $stmt_select->close();

    // Iniciar la transacción
    $conexion->begin_transaction();

    // Si el encargado ha cambiado
    if ($rut_actual != $nuevo_encargado) {
        // Terminar el historial del chofer anterior
        if ($rut_actual) {
            $sql_terminar_historial = "
                UPDATE chofer_historial 
                SET fecha_termino = CURDATE(), kilometraje_termino = ? 
                WHERE patente = ? AND rut_chofer = ? AND fecha_termino IS NULL";
            $stmt_terminar_historial = $conexion->prepare($sql_terminar_historial);
            $stmt_terminar_historial->bind_param("iss", $km_actual, $patente, $rut_actual);
            $stmt_terminar_historial->execute();
        }

        // Crear un nuevo registro de historial para el nuevo chofer
        $sql_nuevo_historial = "
            INSERT INTO chofer_historial (patente, rut_chofer, fecha_inicio, kilometraje_inicio) 
            VALUES (?, ?, CURDATE(), ?)";
        $stmt_nuevo_historial = $conexion->prepare($sql_nuevo_historial);
        $stmt_nuevo_historial->bind_param("ssi", $patente, $nuevo_encargado, $km_actual);
        $stmt_nuevo_historial->execute();
    }

    // Actualizar el vehículo
    $sql_actualizar = "
        UPDATE vehiculo 
        SET marca = ?, modelo = ?, año = ?, km_actual = ?, fecha_revision_tecnica = ?, rut = ?
        WHERE patente = ?";
    $stmt_actualizar = $conexion->prepare($sql_actualizar);
    $stmt_actualizar->bind_param("ssiisss", $marca, $modelo, $año, $km_actual, $revision_tecnica, $nuevo_encargado, $patente);
    $stmt_actualizar->execute();

    // Insertar en la tabla `km_historial`
    $sql_insert_historial = "INSERT INTO km_historial (patente, km, fecha_actualizacion, actualizado_por) 
                             VALUES (?, ?, NOW(), ?)";
    $stmt_historial = $conexion->prepare($sql_insert_historial);
    $stmt_historial->bind_param("sis", $patente, $km_actual, $actualizado_por);
    $stmt_historial->execute();

    // Confirmar la transacción si todo es exitoso
    $conexion->commit();
    $icono = "success";
    $mensaje = "Vehículo y historial de chofer actualizado correctamente.";
} catch (Exception $e) {
    $conexion->rollback(); // Deshacer la transacción en caso de error
    $icono = "error";
    $mensaje = "Error al actualizar: " . $e->getMessage();
}

// Redirigir con el estado y el mensaje
header("Location: ../vehiculos.php?status=$icono&mensaje=$mensaje");
exit();
?>
