<?php
session_start();

// Verifica si el usuario tiene los permisos adecuados
if (!isset($_SESSION['rut']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)) {
    header("Location: ../login/login.php");
    exit();
}

include("../../conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_solicitud = isset($_POST['id_solicitud']) ? $_POST['id_solicitud'] : null;
    $accion = isset($_POST['accion']) ? $_POST['accion'] : null;

    // Verificar que los datos requeridos estén presentes
    if (empty($id_solicitud) || empty($accion)) {
        header("Location: ../lista_solicitudes.php?error=Faltan datos en la solicitud.");
        exit();
    }

    // Verificar si el supervisor autenticado tiene permiso para gestionar esta solicitud
    $sql_verificar = "
        SELECT u.supervisor 
        FROM solicitud_combustible sc 
        JOIN usuario u ON sc.rut = u.rut 
        WHERE sc.id_solicitud = ? AND (u.supervisor = ? OR ? = 1)";

    $stmt_verificar = $conexion->prepare($sql_verificar);
    $stmt_verificar->bind_param('ssi', $id_solicitud, $_SESSION['rut'], $_SESSION['rol']);
    $stmt_verificar->execute();
    $resultado_verificar = $stmt_verificar->get_result();

    if ($resultado_verificar->num_rows === 0) {
        header("Location: ../lista_solicitudes.php?error=No tienes permisos para gestionar esta solicitud.");
        exit();
    }

    // Obtener datos de la solicitud de combustible
    $sql_solicitud = "SELECT patente, kilometraje FROM solicitud_combustible WHERE id_solicitud = ?";
    $stmt_solicitud = $conexion->prepare($sql_solicitud);
    $stmt_solicitud->bind_param("i", $id_solicitud);
    $stmt_solicitud->execute();
    $resultado_solicitud = $stmt_solicitud->get_result();

    if ($resultado_solicitud->num_rows > 0) {
        $solicitud = $resultado_solicitud->fetch_assoc();
        $patente = $solicitud['patente'];
        $nuevo_km = $solicitud['kilometraje'];
    } else {
        header("Location: ../lista_solicitudes.php?error=No se encontró la solicitud de combustible.");
        exit();
    }

    // Iniciar una transacción para garantizar la integridad de los datos
    $conexion->begin_transaction();

    try {
        if ($accion === 'aprobar') {
            $nuevo_estado = 'Aprobada';

            // Actualizar el estado de la solicitud y el autorizador
            $sql_update = "UPDATE solicitud_combustible SET estado = ?, rut_autorizador = ? WHERE id_solicitud = ?";
            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->bind_param('ssi', $nuevo_estado, $_SESSION['rut'], $id_solicitud);
            $stmt_update->execute();

            if ($stmt_update->affected_rows >= 0) {
                // Actualizar el kilometraje del vehículo
                $sql_actualizar_km = "UPDATE vehiculo SET km_actual = ? WHERE patente = ?";
                $stmt_actualizar_km = $conexion->prepare($sql_actualizar_km);
                $stmt_actualizar_km->bind_param("is", $nuevo_km, $patente);
                $stmt_actualizar_km->execute();

                if ($stmt_actualizar_km->affected_rows >= 0) {
                    // Insertar en el historial de kilometraje
                    $sql_historial = "INSERT INTO km_historial (patente, km, fecha_actualizacion, actualizado_por) 
                                      VALUES (?, ?, NOW(), ?)";
                    $stmt_historial = $conexion->prepare($sql_historial);
                    $stmt_historial->bind_param("sis", $patente, $nuevo_km, $_SESSION['rut']);
                    $stmt_historial->execute();

                    if ($stmt_historial->affected_rows > 0) {
                        // Confirmar la transacción
                        $conexion->commit();
                        $mensaje = "Solicitud aprobada y kilometraje actualizado con éxito.";
                        $icono = "success";
                    } else {
                        throw new Exception("Error al registrar en el historial de kilometraje.");
                    }
                } else {
                    throw new Exception("Error al actualizar el kilometraje del vehículo.");
                }
            } else {
                throw new Exception("Error al actualizar el estado de la solicitud.");
            }

        } elseif ($accion === 'denegar') {
            $nuevo_estado = 'Denegada';

            // Actualizar el estado de la solicitud
            $sql_update = "UPDATE solicitud_combustible SET estado = ?, rut_autorizador = ? WHERE id_solicitud = ?";
            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->bind_param('ssi', $nuevo_estado, $_SESSION['rut'], $id_solicitud);
            $stmt_update->execute();

            if ($stmt_update->affected_rows >= 0) {
                $conexion->commit();
                $mensaje = "Solicitud denegada exitosamente.";
                $icono = "success";
            } else {
                throw new Exception("Error al denegar la solicitud.");
            }

        } else {
            throw new Exception("Acción no válida.");
        }
    } catch (Exception $e) {
        // Deshacer la transacción en caso de error
        $conexion->rollback();
        $mensaje = "Error al gestionar la solicitud: " . $e->getMessage();
        $icono = "error";
    }

    // Redirigir de vuelta con un mensaje
    header("Location: ../lista_solicitudes.php?status=$icono&mensaje=$mensaje");
    exit();
} else {
    header("Location: ../lista_solicitudes.php");
    exit();
}
?>
