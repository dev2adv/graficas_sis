<?php
require_once __DIR__ . '/vendor/autoload.php';
use Dompdf\Dompdf;
include_once("Conexion.php");
session_start();
$con=CConexion::ConexionDB();
$dompdf = new Dompdf();
//var_dump($_GET);
$importadora = $_GET['importadora'] ?? '';
$representante = $_GET['representante'] ?? '';
//$mensaje = $_POST['mensaje'] ?? '';
//$firma = $_POST['emisor'] ?? '';

    $usuario = 'IVAlan'; //$_SESSION['usuario'];
    //echo $usuario;
    $sqli=" SELECT UPPER( b.trabajador) AS TRABAJADOR ,b.email,UPPER(b.cargo) AS CARGO ,c.sucursal,d.rol_nombre,d.rol_id,
	'(+591) '||b.celular as celular, c.telefono, c.direccion,c.ciu_id, e.ciudad, c.pais
    FROM usuarios a, trabajador b, cat_sucursal c, roles d, cat_ciudad e
    where a.per_id=b.id and us_email= '$usuario' 
    and b.sucursal=c.id 
    and a.rol_id=d.rol_id
    and c.ciu_id=e.id";
    //var_dump($sqli);
    $resul=$con->query($sqli);
    $firma=$resul->fetch();
    /*echo $resul->fetch();
    var_dump($firma);
    echo $firma['trabajador'];
    echo $firma['cargo'];
    echo $firma['email'];
    echo $firma['celular'];
    echo $firma['telefono'];
    echo $firma['direccion'];*/

    $con->query('SET lc_time TO "es_ES.UTF-8";'); // Ejecutar configuración de idioma

    $sqlf = 'select TO_CHAR(NOW(), \'DD "de" Month "de" YYYY\') AS fecha;'; // Ajustar Month
    $resulf = $con->query($sqlf);
    $fecha = $resulf->fetch();
    
    

$rutaImagen = 'images/Presentación A4.jpg';
$tipo = pathinfo($rutaImagen, PATHINFO_EXTENSION);
$datos = file_get_contents($rutaImagen);
$base64 = 'data:image/' . $tipo . ';base64,' . base64_encode($datos);

//$html = '<img src="' . $base64 . '" width="100%" height="100%">';


// Definir estilos con imagen de fondo y capa de texto
$html = '
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">



<style>
    @page {
        margin: 0;
    }
    body {
        font-family: "Montserrat", sans-serif;
        font-weight: 500; /* Estilo más clásico */
        font-size: 16px;
        line-height: 1.5;
        text-align: justify;
        margin: 0;
        padding: 0;
        position: relative;
    }
    .fondo img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }
    .contenido {
        position: relative;
        z-index: 1;
        padding: 40px;
        border-radius: 14px;
        top: 80;
    }
    .titulo {
        font-size: 12px;
        font-weight: bold;
        text-align: center;
    }
    .viñetas {
        margin-left: 40px;
        font-weight: bold;
    }
    .remite p,
    .firma p {
        margin: 0;
        padding: 0;
        text-align: lefht;
    }
    .limite-parrafo {
        width: 9cm; /* Establecer el ancho máximo */
        word-wrap: break-word; /* Asegurar que las palabras largas se ajusten */
        overflow-wrap: break-word; /* Alternativa para navegadores */
    }

</style>


<div class="fondo">
    <img src="' . $base64 . '" width="100%" height="100%">
</div>

<div class="contenido">
   <div class="remite">
    
    <br>
    <p><strong>Señores:</strong></p>
    <p><strong> '.$importadora.'</strong></p>
    <p><strong>'.$representante.'</strong></p>
    <p><strong>Presente.-</strong></p>
   </div>
<br>
    <p>Un gusto saludarle por este medio.</p>
<p>Nos complace presentar nuestra empresa de transporte internacional de carga, una compañía con una sólida trayectoria en el mercado y con una fuerte orientación de familia que guía nuestro enfoque en el servicio al cliente.</p>

<p>Nos enorgullece contar con un equipo de profesionales altamente capacitados y con amplia experiencia en el sector logístico, lo que nos permite brindar soluciones eficientes y seguras para la gestión de cargas internacionales en importaciones y exportaciones como:</p>

<ul class="viñetas">
    <li>TRANSPORTE MARÍTIMO DESDE CUALQUIER PARTE DEL MUNDO (CONTENEDORES Y CARGA SUELTA).</li>
    <li>TRANSPORTE AÉREO DESDE CUALQUIER PARTE DEL MUNDO.</li>
    <li>TRANSPORTE TERRESTRE HASTA SUS ALMACENES.</li>
    <li>TRANSPORTE MULTIMODAL.</li>
    <li>CARGA DE PROYECTOS.</li>
    <li>SEGURO DE CARGA.</li>
    <li>GIROS A PROVEEDORES DEL EXTERIOR.</li>
</ul>


<p>Nos esforzamos por mantener una comunicación cercana y transparente con nuestros clientes, entendemos que cada carga es única y requiere de una atención personalizada.</p>
<p>Saludos cordiales.</p>
<p >Atentamente,</p>
<br>
<br>
<br>
<div class="firma">
<p style="font-size: 16px;"><strong>'.$firma['trabajador'].'</strong></p>
<p style="font-size: 13px;"><strong>'.$firma['cargo'].'</strong></p>
<p style="font-size: 13px;">'.$firma['email'].'</p>
<p style="font-size: 13px;">'.$firma['celular'].'</p>
<p style="font-size: 13px;">'.$firma['telefono'].'</p>
<p class="limite-parrafo" style="font-size: 13px;">'.$firma['direccion'].'. '.$firma['pais'].'</p>
<p style="font-size: 13px;"></p>
</div>
</div>';
//echo $html;
//exit(); // Detener ejecución para revisar el HTML


// Cargar contenido HTML en Dompdf
$dompdf->loadHtml($html);

// Establecer tamaño de hoja A4 en orientación vertical
$dompdf->setPaper('A4', 'portrait');

// Renderizar PDF
$dompdf->render();

// Descargar PDF en el navegador
$dompdf->stream("archivo_con_fondo.pdf", array("Attachment" => false));
?>
