<?php

session_start();
require_once "Conexion.php";
require 'vendor/autoload.php';
//include('login.php');

if (!isset($_SESSION['usuario'])) {
    echo "Usuario no autenticado.";
    exit;
}

$usuario = $_SESSION['usuario'];
$con = CConexion::ConexionDB();
//var_dump($_GET);
//var_dump($_POST);

$mes=isset($_GET['mes'])?$_GET['mes']:'';
var_dump($mes);
// Usar las clases necesarias de PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


try {

    $sqlu = " select b.trabajador, c.sucursal,to_char(now(),'dd/mm/yyyy hh24:mi:ss') as fecha from usuarios a, trabajador b, cat_sucursal c
              where a.per_id=b.id and a.us_email='QLuis' and b.sucursal=c.id";
    $stmtu = $con->query($sqlu);     
    $rowu = $stmtu->fetch(PDO::FETCH_ASSOC);   

    // Realizar una consulta SQL
    $sql = "SELECT * FROM embarques WHERE vendedor = '$usuario'
    AND CAST(CONCAT(CAST(EXTRACT(year FROM fllegada) AS INT), '', LPAD(CAST(EXTRACT(MONTH FROM fllegada) AS INT)::text, 2, '0')) AS INT)= $mes";
    $stmt = $con->query($sql);

    // Crear una nueva hoja de cálculo
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // declare styles
    $styleHead = [
        'font' => [ 'bold' => true,
        'color' => ['rgb' => '000080'],
    ],
        'fill' => [ 'fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'ADD8E6'] ], 
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000']
            ]
            ],
    ];

    $styleBold = [
        'font' => [ 'bold' => true ]
    ];

    $styleTotal = [
        'font' => [ 'bold' => true ],
        'fill' => [ 'fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'ADD8E6'] ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000']
            ]
            ],
    ];

    $styleArray = [
        'font' => [
            'bold' => false,
            'color' => ['rgb' => '000000'],
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'F0F8FF'],
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000']
            ]
        ]
    ];
    

    // set title styles
    $sheet->getStyle('A1:Y1')->applyFromArray($styleBold);
    $sheet->setCellValue('A1', "Reporte de Ventas: Periodo ".$mes." Vendedor ".$rowu['trabajador']);
    $sheet->getStyle('A2:Y2')->applyFromArray($styleBold);
    $sheet->setCellValue('A2', "Sucursal: ".$rowu['sucursal']." Fecha emisión: ".$rowu['fecha']);
    // Escribir los encabezados de las columnas
    $columns = ['ro', 'shipper', 'mbl', 'proveedor', 'consignatario', 'ncontenedor', 'tcontenedor', 'ccontenedor', 'mercancia', 'porigen', 
    'pllegada', 'fsalida', 'fllegada', 'invoice', 'venta', 'comprat', 'ventas', 'compras', 'ventat', 'totalp', 
    'tcontable', 'tipot', 'naviera', 'obs', 'nro']; // Ajusta según tus columnas

    $columnIndex = 'A'; // Empieza en la columna 3 (A)
    foreach ($columns as $column) {
        //var_dump($column);
        $sheet->setCellValue($columnIndex. '4', $column);
        $columnIndex++;
    }
    // set header styles
    $sheet->getStyle('A4:Y4')->applyFromArray($styleHead);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);
    $sheet->getColumnDimension('G')->setAutoSize(true);
    $sheet->getColumnDimension('H')->setAutoSize(true);
    $sheet->getColumnDimension('I')->setAutoSize(true);
    $sheet->getColumnDimension('J')->setAutoSize(true);
    $sheet->getColumnDimension('K')->setAutoSize(true);
    $sheet->getColumnDimension('L')->setAutoSize(true);
    $sheet->getColumnDimension('M')->setAutoSize(true);
    $sheet->getColumnDimension('N')->setAutoSize(true);
    $sheet->getColumnDimension('O')->setAutoSize(true);
    $sheet->getColumnDimension('P')->setAutoSize(true);
    $sheet->getColumnDimension('Q')->setAutoSize(true);
    $sheet->getColumnDimension('R')->setAutoSize(true);
    $sheet->getColumnDimension('S')->setAutoSize(true);
    $sheet->getColumnDimension('T')->setAutoSize(true);
    $sheet->getColumnDimension('U')->setAutoSize(true);
    $sheet->getColumnDimension('V')->setAutoSize(true);
    $sheet->getColumnDimension('W')->setAutoSize(true);
    $sheet->getColumnDimension('X')->setAutoSize(true);
    $sheet->getColumnDimension('Y')->setAutoSize(true);
    

    // Escribir los datos de la consulta
    $rowIndex = 5;
    $nrorow = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sheet->getStyle('A'.$rowIndex.':Y'.$rowIndex)->applyFromArray($styleArray);
        $sheet->setCellValue('A'. $rowIndex, $row['ro']);
        $sheet->setCellValue('B'. $rowIndex, $row['shipper']);
        $sheet->setCellValue('C'. $rowIndex, $row['mbl']);
        $sheet->setCellValue('D'. $rowIndex, $row['proveedor']);
        $sheet->setCellValue('E'. $rowIndex, $row['consignatario']);
        $sheet->setCellValue('F'. $rowIndex, $row['ncontenedor']);
        $sheet->setCellValue('G'. $rowIndex, $row['tcontenedor']);
        $sheet->setCellValue('H'. $rowIndex, $row['ccontenedor']);
        $sheet->setCellValue('I'. $rowIndex, $row['mercancia']);
        $sheet->setCellValue('J'. $rowIndex, $row['porigen']);
        $sheet->setCellValue('K'. $rowIndex, $row['pllegada']);
        $sheet->setCellValue('L'. $rowIndex, $row['fsalida']);
        $sheet->setCellValue('M'. $rowIndex, $row['fllegada']);
        $sheet->setCellValue('N'. $rowIndex, $row['invoice']);
        $sheet->setCellValue('O'. $rowIndex, $row['venta']);
        $sheet->setCellValue('P'. $rowIndex, $row['comprat']);
        $sheet->setCellValue('Q'. $rowIndex, $row['ventas']);
        $sheet->setCellValue('R'. $rowIndex, $row['compras']);
        $sheet->setCellValue('S'. $rowIndex, $row['ventat']);
        $sheet->setCellValue('T'. $rowIndex, $row['totalp']);
        $sheet->setCellValue('U'. $rowIndex, $row['tcontable']);
        $sheet->setCellValue('V'. $rowIndex, $row['tipot']);
        $sheet->setCellValue('W'. $rowIndex, $row['naviera']);
        $sheet->setCellValue('X'. $rowIndex, $row['obs']);
        $sheet->setCellValue('Y'. $rowIndex, $row['nro']);
        $nrorow= $nrorow+1;
        $rowIndex++;
    }
    
    // set resume
    $totalRows = $nrorow+2;
   

    $rowSub = $totalRows + 3;
    $rowIGV = $totalRows + 4;
    $rowTot = $totalRows + 5;

    //$sheet->setCellValue('D'.$rowSub,'Subtotal:');
    $sheet->getStyle('A'.$rowSub.':Y'.$rowSub)->applyFromArray($styleTotal);
    $sheet->setCellValue('H'.$rowSub,"=COUNT(H4:H".($totalRows+1).")");   // calculate subtotal
    $sheet->setCellValue('O'.$rowSub,"=SUM(O4:O".($totalRows+1).")");   // calculate subtotal
    $sheet->setCellValue('P'.$rowSub,"=SUM(P4:P".($totalRows+1).")");   // calculate subtotal
    $sheet->setCellValue('Q'.$rowSub,"=SUM(Q4:Q".($totalRows+1).")");   // calculate subtotal
    $sheet->setCellValue('R'.$rowSub,"=SUM(R4:R".($totalRows+1).")");   // calculate subtotal
    $sheet->setCellValue('S'.$rowSub,"=SUM(S4:S".($totalRows+1).")");   // calculate subtotal
    $sheet->setCellValue('T'.$rowSub,"=SUM(T4:T".($totalRows+1).")");   // calculate subtotal
    $sheet->setCellValue('U'.$rowSub,"=SUM(U4:U".($totalRows+1).")");   // calculate subtotal

    //$sheet->setCellValue('D'.$rowIGV,'IGV:');
    /*$sheet->setCellValue('E'.$rowIGV,"=E".$rowSub."*0.18");             // calculate tax

    $sheet->setCellValue('D'.$rowTot,'Total:');
    $sheet->setCellValue('E'.$rowTot,"=E".$rowSub."*1.18");             // calculate total

    $sheet->getStyle('D'.$rowSub.':D'.$rowIGV)->applyFromArray($styleBold);
    $sheet->getStyle('D'.$rowTot.':E'.$rowTot)->applyFromArray($styleTotal);*/

    // Guardar el archivo en formato Excel
    $writer = new Xlsx($spreadsheet);
    ob_clean(); // Limpia el buffer de salida
    ob_start(); // Inicia un nuevo buffer
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Reporte_Ventas.xlsx"');
    header('Cache-Control: max-age=0');
    //$writer->save('C:\Descargas\prueba.xlsx');
    $writer->save('php://output');

    //echo "¡Reporte generado con éxito! RUTA -> C:\Users\Ventas\\reporte.xlsx ";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>