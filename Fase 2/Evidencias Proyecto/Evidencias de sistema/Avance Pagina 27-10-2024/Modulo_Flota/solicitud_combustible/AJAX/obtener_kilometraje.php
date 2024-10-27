<?php
require '../../conexion.php'; // Asegúrate de conectar a la base de datos

if (isset($_POST['patente'])) {
    $patente = $_POST['patente'];

    // Consulta para obtener el kilometraje del vehículo seleccionado
    $sql = "SELECT km_actual FROM vehiculo WHERE patente = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('s', $patente);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        echo $fila['km_actual']; // Devolver el kilometraje
    } else {
        echo "0"; // Devolver 0 si no se encuentra el vehículo
    }

    $stmt->close();
    $conexion->close();
}
?>
