<?php
include('../../conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patente = $_POST['Patente'];
    $id_tipo_siniestro = $_POST['id_tipo_siniestro'];
    $fecha = $_POST['fecha'];
    $daño = $_POST['Daño'];
    $rut = $_POST['Rut'];

    try {
        // Inserción en la tabla siniestro
        $sql = "INSERT INTO siniestro (patente, fecha, id_tipo_siniestro, daño, rut) VALUES (?, ?, ?, ?, ?)";
        $stmt_siniestro = mysqli_prepare($conexion, $sql);

        if (!$stmt_siniestro) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($conexion));
        }

        mysqli_stmt_bind_param($stmt_siniestro, "ssiss", $patente, $fecha, $id_tipo_siniestro, $daño, $rut);

        if (mysqli_stmt_execute($stmt_siniestro)) {
            // Si la inserción fue exitosa
            $icono = "success";
            $mensaje = "Siniestro agregado exitosamente.";
        } else {
            // Si ocurre algún error al ejecutar la consulta
            throw new Exception("No se pudo agregar el siniestro.");
        }

        // Cerrar la sentencia preparada
        mysqli_stmt_close($stmt_siniestro);
    } catch (Exception $e) {
        // Capturar errores
        $icono = "error";
        $mensaje = "Hubo un error al agregar el siniestro: " . $e->getMessage();
    }

    // Redirigir de nuevo a la página con el estado y el mensaje
    header("Location: ../registro_siniestro.php?status=$icono&mensaje=$mensaje");
    exit();
}
?>
