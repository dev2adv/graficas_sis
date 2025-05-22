

<?php
session_start();
include_once("Conexion.php");
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$con = CConexion::ConexionDB();
// Convertir la imagen a base64
$imagePath = 'C:/Users/PC/Pictures/NUEVO.png'; // Ruta de la imagen
$type = pathinfo($imagePath, PATHINFO_EXTENSION);
$data = file_get_contents($imagePath);
$base64Image = 'data:image/' . $type . ';base64,' . base64_encode($data);

if (!isset($_SESSION['usuario'])) {
    echo "Usuario no autenticado.";
    exit;
}

var_dump($_GET);

if (isset($_GET['mes'])) {
    $mes = $_GET['mes'];
    $usuario=$_SESSION['usuario'];
    //var_dump($usuario);
    $consulta_actual = "SELECT 
                        a.nro,a.proveedor, a.consignatario, a.porigen, a.ro, a.tccontenedor,
                        a.fsalida,  a.fllegada,a.servicio,a.mbl,a.ttransporte,a.naviera,
                        a.ventat,a.obs, a.pllegada,
                        (SELECT STRING_AGG(ncontenedor, ', ') 
                        FROM embarqueventas_det b 
                        WHERE b.idnro=a.nro) AS ncontenedor,
                        (SELECT STRING_AGG(tcontenedor, ', ') 
                        FROM embarqueventas_det b 
                        WHERE b.idnro=a.nro) AS tcontenedor
                        FROM embarqueventas a
                        WHERE a.consignatario = '$mes' and a.vendedor = '$usuario'
                        ORDER BY a.fllegada ASC";
    
    $resultado_actual = $con->prepare($consulta_actual);
  //  $resultado_actual->bindParam(':mes', $mes);
  //  $resultado_actual->bindParam(':usuario', $usuario);
    //var_dump($resultado_actual);
    $resultado_actual->execute();
    $lista = $resultado_actual->fetchAll(PDO::FETCH_ASSOC);
    
    $sql="  SELECT UPPER( b.trabajador) AS TRABAJADOR ,b.email,UPPER(b.cargo) AS CARGO ,c.sucursal,d.rol_nombre
            FROM usuarios a, trabajador b, cat_sucursal c, roles d
            where a.per_id=b.id and us_email= :user 
            and b.sucursal=c.id 
            and a.rol_id=d.rol_id ";
    $consulta=$con->prepare($sql);
    //echo $ida;
    $consulta->bindParam(':user',$usuario);
    $consulta->execute();
    $usnombre=$consulta->fetch(PDO::FETCH_ASSOC);
    //$nombre = 'kriss' ;
    
    // Configurar opciones de Dompdf
    $options = new Options();
    $options->set('isRemoteEnabled', true); // Permitir cargar imágenes remotas si es necesario
    $dompdf = new Dompdf($options);

    $fecha = new DateTime();

       

    //if (isset($_GET['pdf']) && $_GET['pdf'] == 1) {
        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>ADVANCELINE SRL</title>
            <link rel="shortcut icon" href="images/SoloA Logo.png" type="image/x-icon" />
            <link rel="stylesheet" href="estilos.css">
        </head>
        <body>
            
            <img src="'.$base64Image.'" style="width: 120px;">
            <br>
            <br>
            <div style="padding: 5px;">
                <h2 style="text-align: center;"> CUADRO DE SERVICIOS</h2>
                <br>
                <div>Cliente : ' . htmlspecialchars($mes ?? '') . '</div>
                <div>Fecha emisión: ' . $fecha -> format('Y-m-d H:i:s'). '</div>
                <br>
                <table style="font-size: 8px; border: 1px black solid; border-collapse: collapse; text-align: left;">
                <thead style="color: white; background-color: #e40521; border-bottom: solid 3px #ea2906; font-size: 8px;">
                    <tr>
                        <th>RO</th>
                        <th>CONSIGNATARIO</th>
                        <th>PROVEEDOR</th>
                        <th>PUERTO SALIDA</th>
                        <th>ETD</th>
                        <th>PUERTO LLEGADA</th>
                        <th>ETA</th>
                        <th>MBL</th>
                        <th>OHBL</th>
                        <th>NUMERO CONTENEDOR</th>
                        <th>TIPO CONTENEDOR</th>
                        <th>SERVICIO</th>
                        <th>CANTIDAD CONTENEDOR</th>
                        <th>FLETE </th>
                        <th>NAVIERA</th>
                        <th>VENTA TOTAL</th>
                        <th>OBSERVACIONES</th>
                    </tr>
                </thead>
                <tbody>';
                
        // Aquí se cierra la cadena y se utiliza el bucle foreach
        foreach ($lista as $key => $dato) {
            $html .= '
                    <tr style="text-align: center;">
                        <td>' . htmlspecialchars($dato['ro'] ?? '') . '</td>
                        <td>' . htmlspecialchars($dato['consignatario'] ?? '') . '</td>
                        <td>' . htmlspecialchars($dato['proveedor'] ?? '') . '</td>
                        <td>' . htmlspecialchars($dato['porigen'] ?? '') . '</td>
                        <td style="width: 5%;">' . htmlspecialchars($dato['fsalida'] ?? '') . '</td>
                        <td>' . htmlspecialchars($dato['pllegada'] ?? '') . '</td>
                        <td style="width: 5%;">' . htmlspecialchars($dato['fllegada'] ?? '') . '</td>
                        <td>' . htmlspecialchars($dato['mbl'] ?? '') . '</td>
                        <td>' . htmlspecialchars($dato['ohbl'] ?? '') . '</td>
                        <td>' . htmlspecialchars($dato['ncontenedor'] ?? '') . '</td>
                        <td>' . htmlspecialchars($dato['tcontenedor'] ?? '') . '</td>
                        <td>' . htmlspecialchars($dato['servicio'] ?? '') . '</td>
                        <td>' . htmlspecialchars($dato['tcontenedor'] ?? '') . '</td>
                        <td>' . htmlspecialchars($dato['ttransporte'] ?? '') . '</td>
                        <td>' . htmlspecialchars($dato['naviera'] ?? '') . '</td>
                        <td>' . htmlspecialchars($dato['ventat'] ?? '') . '</td>
                        <td>' . htmlspecialchars($dato['obs'] ?? '') . '</td>
                    </tr>';
        }
                
        $html .= '</tbody>
                </table>
            </div>
            <br>
            <br>
            <div>    
                <span class="navbar-text" style="font-size: 11px; text-align: lefth;  color: rgb(5, 5, 5);">
                    <div>' . htmlspecialchars($usnombre["trabajador"] ?? '') . '</div>
                    <div>' . htmlspecialchars($usnombre["cargo"] ?? '') . '</div>
                    <div>' . htmlspecialchars($usnombre["email"] ?? '') . '</div>
                    <div id="suc">' . htmlspecialchars($usnombre["sucursal"] ?? '') . '</div>
                    <div>' . htmlspecialchars($usuario . " - " . $usnombre["rol_nombre"] ?? '') . '</div>
                </span>
            </div>
        </body>
        </html>';
        
        //$dompdf = new Dompdf();
        //$options = $dompdf->getOptions();
        //$options->set(array('isRemoteEnabled' => true));
        $dompdf->setOptions($options);
        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($html);
        // Configurar tamaño y orientación del papel
        $dompdf->setPaper('letter', 'landscape');
        // renderizar el PDF
        $dompdf->render();
        //mostrar o guardar el PDF
        $dompdf->stream("archivo_.pdf", array("Attachment" => false));
    /*} else {
        echo generarTabla($datos['actual'], "Registros del Mes ".$mes);
        
    }*/
}
?>