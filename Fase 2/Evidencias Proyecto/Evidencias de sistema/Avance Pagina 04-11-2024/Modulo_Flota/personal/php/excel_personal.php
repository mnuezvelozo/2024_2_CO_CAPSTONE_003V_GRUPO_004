<?php

include("../../conexion.php");

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Consulta SQL para obtener todos los usuarios con los nombres de rol, cargo y supervisor
$sql_usuarios = "
    SELECT 
        u.rut,
        u.nombre,
        u.fecha_ingreso,
        u.fecha_termino,
        COALESCE(r.nombre_rol, 'N/A') AS rol,
        COALESCE(c.nombre_cargo, 'N/A') AS cargo,
        COALESCE(CONCAT(s.rut, ' - ', s.nombre), 'N/A') AS supervisor,
        u.activo
    FROM 
        usuario u
    LEFT JOIN 
        roles r ON u.Id_Rol = r.Id_Rol
    LEFT JOIN 
        cargo c ON u.id_cargo = c.id_cargo
    LEFT JOIN 
        usuario s ON u.supervisor = s.rut;
";

$stmt_usuarios = $conexion->prepare($sql_usuarios);
$stmt_usuarios->execute();
$resultados_usuarios = $stmt_usuarios->get_result();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Establecer encabezados de columnas en la hoja de cálculo
$sheet->getStyle('A1:H1')->getFont()->setBold(true);
$sheet->setCellValue('A1', 'RUT');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Fecha Ingreso');
$sheet->setCellValue('D1', 'Fecha Término');
$sheet->setCellValue('E1', 'Rol');
$sheet->setCellValue('F1', 'Cargo');
$sheet->setCellValue('G1', 'Supervisor');
$sheet->setCellValue('H1', 'Activo');

$row = 2;
while ($data = $resultados_usuarios->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $data['rut']);
    $sheet->setCellValue('B' . $row, $data['nombre']);
    $sheet->setCellValue('C' . $row, $data['fecha_ingreso']);
    $sheet->setCellValue('D' . $row, $data['fecha_termino']);
    $sheet->setCellValue('E' . $row, $data['rol']);
    $sheet->setCellValue('F' . $row, $data['cargo']);
    $sheet->setCellValue('G' . $row, $data['supervisor']);
    $sheet->setCellValue('H' . $row, $data['activo']);
    $row++;
}

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Listado_Usuarios.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit();

$conexion->close();
