<?php
session_start();

// Verifica si el usuario tiene los permisos adecuados
if (!isset($_SESSION['rut']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)) {
    header("Location: ../login/login.php");
    exit();
}

include("../../conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_solicitud = $_POST['id_solicitud'];
    $accion = $_POST['accion'];

    // Verificar si el supervisor autenticado tiene permiso para gestionar esta solicitud
    $sql_verificar = "
        SELECT u.supervisor 
        FROM solicitud_combustible sc 
        JOIN usuario u ON sc.rut = u.rut 
        WHERE sc.id_solicitud = ? AND (u.supervisor = ? OR ? = 1)";  // Admin (rol = 1) tiene permisos sobre todas las solicitudes

    $stmt_verificar = $conexion->prepare($sql_verificar);
    $stmt_verificar->bind_param('ssi', $id_solicitud, $_SESSION['rut'], $_SESSION['rol']);
    $stmt_verificar->execute();
    $resultado_verificar = $stmt_verificar->get_result();

    if ($resultado_verificar->num_rows === 0) {
        // No tiene permisos para gestionar esta solicitud
        header("Location: ../lista_solicitudes.php?error=No tienes permisos para gestionar esta solicitud.");
        exit();
    }


    if ($accion === 'aprobar') {
        $nuevo_estado = 'Aprobada';
    } elseif ($accion === 'denegar') {
        $nuevo_estado = 'Denegada';
    } else {
        // Acción no válida
        header("Location: ../lista_solicitudes.php?error=Acción no válida.");
        exit();
    }

    // Actualizar el estado de la solicitud en la base de datos
    $sql_update = "UPDATE solicitud_combustible SET estado = ?, rut_autorizador = ? WHERE id_solicitud = ?";
    $stmt = $conexion->prepare($sql_update);
    $stmt->bind_param('ssi', $nuevo_estado, $_SESSION['rut'], $id_solicitud);
    $stmt->execute();

    if ($stmt_update->affected_rows > 0) {
        $mensaje = "Solicitud actualizada exitosamente.";
        $icono = "success";
    } else {
        $mensaje = "Error al actualizar la solicitud.";
        $icono = "error";
    }

    // Redirigir de vuelta con un mensaje
    header("Location: ../lista_solicitudes.php?status=$icono&mensaje=$mensaje");
    exit();
} else {
    header("Location: ../lista_solicitudes.php");
    exit();
}
