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
            $icono = "success";
            $mensaje = "Siniestro actualizado exitosamente.";
        } else {
            throw new Exception("No se pudo actualizar el siniestro.");
        }

        mysqli_stmt_close($stmt_siniestro);
    } catch (Exception $e) {
        $icono = "error";
        $mensaje = "Hubo un error al actualizar el siniestro: " . $e->getMessage();
    }

    header("Location: ../tabla_siniestro.php?status=$icono&mensaje=$mensaje");
    exit();
}
?>
