<?php
include('../../conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_siniestro = $_POST['id_siniestro'];
    $id_tipo_siniestro = $_POST['id_tipo_siniestro'];
    $costo = $_POST['costo'];

    try {
        // Actualizar el siniestro en la base de datos
        $sql = "UPDATE siniestro SET id_tipo_siniestro = ?, costo = ? WHERE id_siniestro = ?";
        $stmt_siniestro = mysqli_prepare($conexion, $sql);

        if (!$stmt_siniestro) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($conexion));
        }

        mysqli_stmt_bind_param($stmt_siniestro, "idi", $id_tipo_siniestro, $costo, $id_siniestro);

        if (mysqli_stmt_execute($stmt_siniestro)) {
            // Si la actualización fue exitosa
            $icono = "success";
            $mensaje = "Siniestro actualizado exitosamente.";
        } else {
            // Si ocurre algún error al ejecutar la consulta
            throw new Exception("No se pudo actualizar el siniestro.");
        }

        // Cerrar la sentencia preparada
        mysqli_stmt_close($stmt_siniestro);
    } catch (Exception $e) {
        // Capturar errores
        $icono = "error";
        $mensaje = "Hubo un error al actualizar el siniestro: " . $e->getMessage();
    }

    // Redirigir de nuevo a la página con el estado y el mensaje
    header("Location: ../tabla_siniestro.php?status=$icono&mensaje=$mensaje");
    exit();
}
?>
