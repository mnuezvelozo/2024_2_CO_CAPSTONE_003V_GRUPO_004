<?php
session_start();
include('../../conexion.php'); // Asegúrate de que la ruta sea correcta

$id_auditoria = $_POST['id_auditoria'];
$danos = $_POST['danos'];
$documentos = $_POST['documentos'];
$funcionamiento = $_POST['funcionamiento'];
$observaciones = $_POST['observaciones'];

// Actualizar la auditoría en la base de datos
$query = "UPDATE auditoria SET 
            danos = '$danos', 
            documentos = '$documentos', 
            funcionamiento = '$funcionamiento', 
            observaciones = '$observaciones', 
            estado = 'Completada' 
          WHERE id_auditoria = '$id_auditoria'";

if (mysqli_query($conexion, $query)) {
    echo "Auditoría completada exitosamente.";
} else {
    echo "Error al completar la auditoría: " . mysqli_error($conexion);
}

// Redireccionar a la página de auditorías pendientes
header("Location: ../auditoria_pendientes.php");
exit();
?>
