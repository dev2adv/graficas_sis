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
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

try {

    $sqlu = " select b.trabajador, c.sucursal,to_char(now(),'dd/mm/yyyy hh24:mi:ss') as fecha from usuarios a, trabajador b, cat_sucursal c
              where a.per_id=b.id and a.us_email='QLuis' and b.sucursal=c.id";
    $stmtu = $con->query($sqlu);     
    $rowu = $stmtu->fetch(PDO::FETCH_ASSOC);   

    $sqls =" SELECT distinct d.sucursal
            FROM embarqueventas a
            INNER JOIN usuarios b ON a.vendedor = b.us_email
            INNER JOIN trabajador c ON b.per_id = c.id
            INNER JOIN cat_sucursal d ON c.sucursal = d.id
            WHERE 
            TO_CHAR(a.fllegada, 'YYYYMM') = '$mes'
            ORDER BY 1 ASC";
    $stmts = $con->prepare($sqls);
    $stmts->execute();
    $results = $stmts->fetchAll(PDO::FETCH_ASSOC);

    

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
    $sheet->getStyle('A1:L1')->applyFromArray($styleBold);
    $sheet->setCellValue('A1', "Reporte General de Ventas: Periodo ".$mes." Emitido por: ".$rowu['trabajador']);
    $sheet->getStyle('A2:L2')->applyFromArray($styleBold);
    $sheet->setCellValue('A2', "Sucursal Emisión: ".$rowu['sucursal']." Fecha emisión: ".$rowu['fecha']);

    // Cargar la imagen
    $imagePath = 'C:\Users\PC\Pictures\NUEVO.png';
    $drawing = new Drawing();
    $drawing->setPath($imagePath);
    $drawing->setCoordinates('J1'); // Celda donde se insertará la imagen
    $drawing->setOffsetX(5); // Desplazamiento en X
    $drawing->setOffsetY(5); // Desplazamiento en Y
    $drawing->setWidth(20); // Ancho de la imagen
    $drawing->setHeight(50); // Alto de la imagen
    $drawing->setWorksheet($spreadsheet->getActiveSheet());

    $colag = 4;
    $colti = 5;
    $rowIndex = 6;
    $rowIni = 6;
    foreach ($results as $rows => $suc) {
        $sheet->getStyle('A'.$colag.':A'.$colag)->applyFromArray($styleHead);
        $sheet->setCellValue('A'.$colag, "Sucursal: ".$suc['sucursal']);
    // Realizar una consulta SQL
    $sql = "SELECT 	c.id, c.trabajador, 
            ROUND(SUM(a.totalp)::numeric, 2) AS profit, 
            SUM(a.tcontable) AS ttcontable, 
            SUM(a.tccontenedor) AS nro_contenedores,
            SUM(CASE WHEN a.ttransporte = 'MARÍTIMO' THEN 1 * a.tccontenedor ELSE 0 END) AS ttipot, 
            SUM(CASE WHEN a.ttransporte = 'AEREO' THEN 1 * a.tccontenedor ELSE 0 END) AS ttipot1,
            SUM(CASE WHEN a.ttransporte = 'TERRESTRE' THEN 1 * a.tccontenedor ELSE 0 END) AS ttipot2,
            SUM(CASE WHEN COALESCE(a.ttransporte,'XX') NOT IN ('MARÍTIMO', 'AEREO', 'TERRESTRE') THEN 1 * a.tccontenedor ELSE 0 END) AS ttipot3,
            SUM(CASE WHEN e.tcontenedor = '20 DRY' THEN 1 * e.ccontenedor ELSE 0 END) AS ctipot, 
            SUM(CASE WHEN e.tcontenedor = '40 DRY' THEN 1  * e.ccontenedor  ELSE 0 END) AS ctipot1,
            SUM(CASE WHEN e.tcontenedor = '40 HC' THEN 1  * e.ccontenedor  ELSE 0 END) AS ctipot2,
            SUM(CASE WHEN COALESCE(e.tcontenedor,'DD') NOT IN ('40 DRY','40 HC','20 DRY') THEN 1  * e.ccontenedor  ELSE 0 END) AS ctipot3,
            d.sucursal
            FROM 
            embarqueventas a
            INNER JOIN embarqueventas_det e ON a.nro = e.idnro
            INNER JOIN usuarios b ON a.vendedor = b.us_email
            INNER JOIN trabajador c ON b.per_id = c.id
            INNER JOIN cat_sucursal d ON c.sucursal = d.id
            WHERE 
            TO_CHAR(a.fllegada, 'YYYYMM') = '$mes'
            AND d.sucursal = '".$suc['sucursal']."'
            GROUP BY d.sucursal,c.trabajador, c.id
            ORDER BY d.sucursal ASC";
    $stmt = $con->query($sql);

    // Escribir los encabezados de las columnas
    $columns = ['VENDEDOR',' TOTAL PROFIT','TOTAL TCONTABLE','CANTIDAD CONTENEDORES','MARITIMO','AEREO','TERRESTRE','OTROS','20 DRY','40 DRY','40 HC','OTROS']; // Ajusta según tus columnas

    $columnIndex = 'A'; // Empieza en la columna 5 (A)
    foreach ($columns as $column) {
        //var_dump($column);
        $sheet->setCellValue($columnIndex. $colti, $column);
        $columnIndex++;
    }
    // set header styles
    $sheet->getStyle('A'.$colti.':L'.$colti)->applyFromArray($styleHead);
    $sheet->getColumnDimension('A')->setAutoSize(true);
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
    /*$sheet->getColumnDimension('M')->setAutoSize(true);
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
    $sheet->getColumnDimension('Y')->setAutoSize(true);*/
    
    $nrorow = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        $sheet->getStyle('A'.$rowIndex.':L'.$rowIndex)->applyFromArray($styleArray);
        $sheet->setCellValue('A'. $rowIndex, $row['trabajador']);
        $sheet->setCellValue('B'. $rowIndex, $row['profit']);
        $sheet->setCellValue('C'. $rowIndex, $row['ttcontable']);
        $sheet->setCellValue('D'. $rowIndex, $row['nro_contenedores']);
        $sheet->setCellValue('E'. $rowIndex, $row['ttipot']);
        $sheet->setCellValue('F'. $rowIndex, $row['ttipot1']);
        $sheet->setCellValue('G'. $rowIndex, $row['ttipot2']);
        $sheet->setCellValue('H'. $rowIndex, $row['ttipot3']);
        $sheet->setCellValue('I'. $rowIndex, $row['ctipot']);
        $sheet->setCellValue('J'. $rowIndex, $row['ctipot1']);
        $sheet->setCellValue('K'. $rowIndex, $row['ctipot2']);
        $sheet->setCellValue('L'. $rowIndex, $row['ctipot3']);
        //$sheet->setCellValue('M'. $rowIndex, $row['sucursal']);
        $nrorow= $nrorow+1;
        $rowIndex++;
    }
    
    // set resume numero de filas
    $totalRows = $rowIndex;
 
    $rowSub = $totalRows;
    //$rowIGV = $totalRows + 4;
    //$rowTot = $totalRows + 5;

    //$sheet->setCellValue('D'.$rowSub,'Subtotal:');
    $sheet->getStyle('A'.$rowSub.':L'.$rowSub)->applyFromArray($styleTotal);
    $sheet->setCellValue('A'.$rowSub,"=COUNTA(A".$rowIni.":A".($totalRows-1).")"); // calculate subtotal
    $sheet->setCellValue('B'.$rowSub,"=SUM(B".$rowIni.":B".($totalRows-1).")");   // calculate subtotal
    $sheet->setCellValue('C'.$rowSub,"=SUM(C".$rowIni.":C".($totalRows-1).")");   // calculate subtotal
    $sheet->setCellValue('D'.$rowSub,"=SUM(D".$rowIni.":D".($totalRows-1).")");   // calculate subtotal
    $sheet->setCellValue('E'.$rowSub,"=SUM(E".$rowIni.":E".($totalRows-1).")");   // calculate subtotal
    $sheet->setCellValue('F'.$rowSub,"=SUM(F".$rowIni.":F".($totalRows-1).")");   // calculate subtotal
    $sheet->setCellValue('G'.$rowSub,"=SUM(G".$rowIni.":G".($totalRows-1).")");   // calculate subtotal
    $sheet->setCellValue('H'.$rowSub,"=SUM(H".$rowIni.":H".($totalRows-1).")");   // calculate subtotal
    $sheet->setCellValue('I'.$rowSub,"=SUM(I".$rowIni.":I".($totalRows-1).")");   // calculate subtotal
    $sheet->setCellValue('J'.$rowSub,"=SUM(J".$rowIni.":J".($totalRows-1).")");   // calculate subtotal
    $sheet->setCellValue('K'.$rowSub,"=SUM(K".$rowIni.":K".($totalRows-1).")");   // calculate subtotal
    $sheet->setCellValue('L'.$rowSub,"=SUM(L".$rowIni.":L".($totalRows-1).")");   // calculate subtotal
    
    $colag = $rowSub + 2;
    $colti = $rowSub + 3;
    $rowIndex = $rowSub + 4;
    $rowIni = $rowSub + 4;

    //$sheet->setCellValue('D'.$rowIGV,'IGV:');
    /*$sheet->setCellValue('E'.$rowIGV,"=E".$rowSub."*0.18");             // calculate tax

    $sheet->setCellValue('D'.$rowTot,'Total:');
    $sheet->setCellValue('E'.$rowTot,"=E".$rowSub."*1.18");             // calculate total

    $sheet->getStyle('D'.$rowSub.':D'.$rowIGV)->applyFromArray($styleBold);
    $sheet->getStyle('D'.$rowTot.':E'.$rowTot)->applyFromArray($styleTotal);*/
    }
    // Guardar el archivo en formato Excel
    $writer = new Xlsx($spreadsheet);
    ob_clean(); // Limpia el buffer de salida
    ob_start(); // Inicia un nuevo buffer
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Reporte_General_Ventas.xlsx"');
    header('Cache-Control: max-age=0');
    //$writer->save('C:\Descargas\prueba.xlsx');
    $writer->save('php://output');

    //echo "¡Reporte generado con éxito! RUTA -> C:\Users\Ventas\\reporte.xlsx ";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>