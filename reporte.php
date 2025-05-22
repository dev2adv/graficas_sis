
<?php
session_start();
include_once("Conexion.php");

if (!isset($_SESSION['usuario'])) {
    echo "Usuario no autenticado.";
    exit;
}

$usuario = $_SESSION['usuario'];

require_once __DIR__ . '/vendor/autoload.php';
use Dompdf\Dompdf;

function obtenerDatos($vendedor, $mes_actual) {
    global $con;

    if (substr($mes_actual,4,2) == '12') {
        $anio = substr($mes_actual,0,4);
        $anios = $anio + 1;
        $mes_anterior = $anios. '01';
        
    }else{
        $mes_anterior = $mes_actual + 1;
    }

    $consulta_actual = "SELECT 
    a.ro, a.servicio, a.ttransporte, a.naviera, a.proveedor, a.consignatario,
    a.mbl,
    (SELECT STRING_AGG(ncontenedor, ', ') 
     FROM embarqueventas_det b 
     WHERE b.idnro=a.nro) AS ncontenedor,
    (SELECT STRING_AGG(tcontenedor, ', ') 
     FROM embarqueventas_det b 
     WHERE b.idnro=a.nro) AS tcontenedor,
    a.tccontenedor,
    (SELECT STRING_AGG(mercancia, ', ') 
     FROM embarqueventas_det b 
     WHERE b.idnro=a.nro) AS mercancia,
    a.porigen, a.fsalida, a.pllegada, a.fllegada, 
    a.ventat, a.comprat, a.totalp, a.tcontable, 
    a.obs, a.nro
    FROM embarqueventas a
    WHERE a.vendedor = ':vendedor'
    AND CAST(CONCAT(CAST(EXTRACT(year FROM fllegada) AS INT), '', LPAD(CAST(EXTRACT(MONTH FROM fllegada) AS INT)::text, 2, '0')) AS INT)=':mes_actual'
    ORDER BY 14 ASC";
    $resultado_actual = $con->prepare($consulta_actual);
    $resultado_actual->bindParam(':vendedor', $vendedor);
    $resultado_actual->bindParam(':mes_actual', $mes_actual);
    $resultado_actual->execute();
    $datos_actuales = $resultado_actual->fetchAll(PDO::FETCH_ASSOC);


    $consulta_anterior = "SELECT 
    a.ro, a.servicio, a.ttransporte, a.naviera, a.proveedor, a.consignatario,
    a.mbl,
    (SELECT STRING_AGG(ncontenedor, ', ') 
     FROM embarqueventas_det b 
     WHERE b.idnro=a.nro) AS ncontenedor,
    (SELECT STRING_AGG(tcontenedor, ', ') 
     FROM embarqueventas_det b 
     WHERE b.idnro=a.nro) AS tcontenedor,
    a.tccontenedor,
    (SELECT STRING_AGG(mercancia, ', ') 
     FROM embarqueventas_det b 
     WHERE b.idnro=a.nro) AS mercancia,
    a.porigen, a.fsalida, a.pllegada, a.fllegada, 
    a.ventat, a.comprat, a.totalp, a.tcontable, 
    a.obs, a.nro
    FROM embarqueventas a
    WHERE a.vendedor = ':vendedor'
    AND CAST(CONCAT(CAST(EXTRACT(year FROM fllegada) AS INT), '', LPAD(CAST(EXTRACT(MONTH FROM fllegada) AS INT)::text, 2, '0')) AS INT)=':mes_anterior'
    ORDER BY 14 ASC";
    $resultado_anterior = $con->prepare($consulta_anterior);
    $resultado_anterior->bindParam(':vendedor', $vendedor);
    $resultado_anterior->bindParam(':mes_anterior', $mes_anterior);
    //$resultado_anterior->bindParam(':a_anterior', $a_anterior);
    $resultado_anterior->execute();
    $datos_anteriores = $resultado_anterior->fetchAll(PDO::FETCH_ASSOC);

    return ['actual' => $datos_actuales, 'anterior' => $datos_anteriores];
}

function generarTabla($lista, $titulo) {
    $ventaTotal = 0;
    $contenedoresTotal = 0;
    $compraTotalT = 0;
    $ventaSTotal = 0;
    $compraSTotal = 0;
    $ventaTotalT = 0;
    $profitTotal = 0;
    $tcontableTotal = 0;
    $casos = 0;

    $html = "<div style='padding: 5px;'>";
    $html .= "<h2>$titulo</h2>";
    $html .= "<table style='font-size: 7px; border: 1px black solid; border-collapse: collapse; text-align:left;'>";
    $html .= '<thead style="color: white; background-color: #e40521; border-bottom: solid 3px #ea2906; font-size: 6px;">';
    $html .= '<tr>';
    $html .= '<th>NRO</th>';
    $html .= '<th>CONSIGNATARIO</th>';
    $html .= '<th>PROVEEDOR</th>';
    $html .= '<th>MBL / BOOKING</th>';
    $html .= '<th>RO</th>';
    $html .= '<th>FECHA SALIDA</th>';
    $html .= '<th>FECHA LLEGADA</th>';
    $html .= '<th>TIPO DE TRANSPORTE</th>';
    $html .= '<th>TIPO DE CONTENEDOR</th>';
    $html .= '<th>CANTIDAD DE CONTENEDOR</th>';
    $html .= '<th>COMPRA TOTAL</th>';
    $html .= '<th>VENTA TOTAL</th>';
    $html .= '<th>TOTAL PROFIT</th>';
    $html .= '<th>OBSERVACIONES</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
    foreach ($lista as $dato) {
        $casos = $casos + 1;
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($casos ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($dato['consignatario'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($dato['proveedor'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($dato['mbl'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($dato['ro'] ?? '') . '</td>';
        $html .= '<td style="width: 5%;">' . htmlspecialchars($dato['fsalida'] ?? '') . '</td>';
        $html .= '<td style="width: 5%;">' . htmlspecialchars($dato['fllegada'] ?? '') . '</td>';
        $html .=  '<td>' . htmlspecialchars($dato['tipot'] ?? ''). '</td>' ;
        $html .=  '<td>' .htmlspecialchars($dato['tcontenedor'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($dato['ccontenedor'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($dato['comprat'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($dato['ventat'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($dato['totalp'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($dato['obs'] ?? '') . '</td>';
        $html .= '</tr>';
        
        $ventaTotal = $ventaTotal + $dato['venta'];
        $contenedoresTotal = $contenedoresTotal + $dato['ccontenedor'];
        $compraTotalT = $compraTotalT + $dato['comprat'] ;
        $ventaSTotal = $ventaSTotal + $dato['ventas'];
        $compraSTotal = $compraSTotal + $dato['compras'];
        $ventaTotalT = $ventaTotalT + $dato['ventat'];
        $profitTotal = $profitTotal + $dato['totalp'];
        $tcontableTotal = $tcontableTotal + $dato['tcontable'];
    }
    // Agregar una fila para los totales 
    $html .= '<tr style="font-weight: bold; background-color: #f2f2f2;">'; 
    $html .= '<td>'.htmlspecialchars($casos ?? '').'</td>'; 
    $html .= '<td colspan="7"></td>'; // celdas vacías que no necesitan totales 
    $html .= '<td>TOTALES</td>'; 
    $html .= '<td>' . htmlspecialchars($contenedoresTotal ?? '') . '</td>'; 
    $html .= '<td>' . htmlspecialchars($compraTotalT ?? '') . '</td>'; 
    $html .= '<td>' . htmlspecialchars($ventaSTotal ?? '') . '</td>'; 
    $html .= '<td>' . htmlspecialchars($profitTotal ?? '') . '</td>'; 
    $html .= '<td></td>'; // columna de observaciones vacía 
    $html .= '</tr>';
    
    $html .= '</tbody></table></div>';
    

    return $html;
}


$con = CConexion::ConexionDB();

if (isset($_GET['mes'])) {
    $mes = $_GET['mes'];

    if (substr($mes,4,2) == '12') {
        $anio = substr($mes,0,4);
        $anios = $anio + 1;
        $mes_anterior = $anios. '01';
        
    }else{
        $mes_anterior = $mes + 1;
    }

    $datos = obtenerDatos($usuario, $mes);

    if (isset($_GET['pdf']) && $_GET['pdf'] == 1) {
        $html = '<!DOCTYPE html><html lang="en"><head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<title>Reporte Mensual</title>';
        $html .= '<link rel="stylesheet" href="estilos.css"></head><body>';
        $html .= 'Hoja de Venta de ' . htmlspecialchars($usuario);
        $html .= '<br>';
        $html .= 'Lista de Ventas del mes de ' . htmlspecialchars($mes);
        $html .= generarTabla($datos['actual'], "Registros del Mes ".$mes);
        $html .= generarTabla($datos['anterior'], "Registros del Mes Pasado ".$mes_anterior);
        $html .= '</body></html>';

        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'landscape');
        $dompdf->render();
        $dompdf->stream("archivo_.pdf", array("Attachment" => false));
    } else {
        echo generarTabla($datos['actual'], "Registros del Mes ".$mes);
        echo generarTabla($datos['anterior'], "Registros del Mes Pasado ".$mes_anterior);
    }
}
?>