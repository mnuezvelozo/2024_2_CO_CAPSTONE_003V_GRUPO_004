<?php

include("../../conexion.php");

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Consulta SQL para obtener todos los vehículos, incluyendo los inactivos y sin responsable
$sql_vehiculos = "
    SELECT
        v.patente,
        v.marca,
        v.modelo,
        v.año,
        v.km_actual,
        v.fecha_revision_tecnica,
        v.rut,
        COALESCE(u.nombre, 'Sin Responsable') AS nombre_responsable,
        v.activo,
        COALESCE(SUM(sc.monto), 0) AS total_gastado,
        COALESCE(SUM(CASE 
            WHEN MONTH(sc.fecha) = MONTH(CURDATE()) AND YEAR(sc.fecha) = YEAR(CURDATE())
            THEN sc.monto ELSE 0 END), 0) AS total_gastado_mes_actual
    FROM vehiculo v
    LEFT JOIN usuario u ON v.rut = u.rut
    LEFT JOIN solicitud_combustible sc ON v.patente = sc.patente
    GROUP BY
        v.patente,
        v.marca,
        v.modelo,
        v.año,
        v.km_actual,
        v.fecha_revision_tecnica,
        v.rut,
        u.nombre,
        v.activo";

$stmt_vehiculos = $conexion->prepare($sql_vehiculos);
$stmt_vehiculos->execute();
$resultados_vehiculos = $stmt_vehiculos->get_result();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Establecer encabezados de columnas en la hoja de cálculo
$sheet->getStyle('A1:L1')->getFont()->setBold(true);
$sheet->setCellValue('A1', 'Patente');
$sheet->setCellValue('B1', 'Marca');
$sheet->setCellValue('C1', 'Modelo');
$sheet->setCellValue('D1', 'Año');
$sheet->setCellValue('E1', 'Kilometraje Actual');
$sheet->setCellValue('F1', 'Fecha Revisión Técnica');
$sheet->setCellValue('G1', 'Rut Responsable');
$sheet->setCellValue('H1', 'Nombre Responsable');
$sheet->setCellValue('I1', 'Activo');
$sheet->setCellValue('J1', 'Total Gastado Mes Actual (CLP)');
$sheet->setCellValue('K1', 'Total Gastado (CLP)');

$row = 2;
while ($data = $resultados_vehiculos->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $data['patente']);
    $sheet->setCellValue('B' . $row, $data['marca']);
    $sheet->setCellValue('C' . $row, $data['modelo']);
    $sheet->setCellValue('D' . $row, $data['año']);
    $sheet->setCellValue('E' . $row, $data['km_actual']);
    $sheet->setCellValue('F' . $row, $data['fecha_revision_tecnica']);
    $sheet->setCellValue('G' . $row, $data['rut'] ?? 'Sin Responsable');
    $sheet->setCellValue('H' . $row, $data['nombre_responsable']);
    $sheet->setCellValue('I' . $row, $data['activo']);

    // Formatear el total gastado por mes y el total general como CLP
    $sheet->setCellValue('J' . $row, $data['total_gastado_mes_actual']);
    $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('"CLP" #,##0');

    $sheet->setCellValue('K' . $row, $data['total_gastado']);
    $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode('"CLP" #,##0');

    $row++;
}

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Listado_Vehiculos.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit();

$conexion->close();
