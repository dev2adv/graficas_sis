<?php
include_once("Conexion.php");
require 'vendor/autoload.php';
session_start();
$con=CConexion::ConexionDB();

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

//var_dump($_SESSION['usuario']);

$importadora = $_POST['importadora'] ?? '';
$representante = $_POST['representante'] ?? '';
$mensaje = $_POST['mensaje'] ?? '';
//$firma = $_POST['emisor'] ?? '';

    $usuario = $_SESSION['usuario'];
    $sqli=" SELECT UPPER( b.trabajador) AS TRABAJADOR ,b.email,UPPER(b.cargo) AS CARGO ,c.sucursal,d.rol_nombre,d.rol_id,
	'(+591) '||b.celular as celular, c.telefono, c.direccion,c.ciu_id, e.ciudad, c.pais
    FROM usuarios a, trabajador b, cat_sucursal c, roles d, cat_ciudad e
    where a.per_id=b.id and us_email= '$usuario' 
    and b.sucursal=c.id 
    and a.rol_id=d.rol_id
    and c.ciu_id=e.id";
    $resul=$con->query($sqli);
    $firma=$resul->fetch();
    /*var_dump($firma);
    echo $firma['trabajador'];
    echo $firma['cargo'];
    echo $firma['email'];
    echo $firma['celular'];
    echo $firma['telefono'];
    echo $firma['direccion'];*/

    $sqlf="  select ', '||to_char(now(), 'DD')||' de '||to_char(now(), 'TMMonth')||' '||to_char(now(), 'YYYY') as fecha";
    $resulf=$con->query($sqlf);
    $fecha=$resulf->fetch();

// Crear documento
$phpWord = new PhpWord();
$section = $phpWord->addSection([
    'marginLeft'   => 1134,
    'marginRight'  => 1134,
    'marginTop'    => 2268,
    'marginBottom' => 850
]);

// Definir estilo de párrafos con espacio sencillo y justificación
$paragraphStyle = [
    'spaceBefore' => 100, // Espacio antes del párrafo (ajustable)
    'spaceAfter' => 200, // Espacio después del párrafo (ajustable)
    'lineHeight' => 1, // Interlineado (1.5 en este caso)
    //'spaceAfter' => 1, // Espaciado entre párrafos reducido
    'alignment' => 'both', // Justificación del texto
    'name' => 'Arial', // Tipo de letra
    'size' => 11 // Tamaño en puntos    
];
$paragraphStylel = [
    'lineHeight' => 1, // Interlineado (1.5 en este caso)
    'spaceBefore' => 0, // Espacio antes del párrafo (ajustable)
    'spaceAfter' => 0, // Espacio después del párrafo (ajustable)
    'bold' => true,
    'name' => 'Arial', // Tipo de letra
    'size' => 9 // Tamaño en puntos    
];

$paragraphStyle1 = [
    'spaceBefore' => 0, // Espacio antes del párrafo (ajustable)
    'spaceAfter' => 0, // Espacio después del párrafo (ajustable)
    'alignment' => 'left', // Justificación del texto
    'bold' => 'true',
    'name' => 'Arial', // Tipo de letra
    'size' => 10 // Tamaño en puntos    
];

// Agregar fecha
$section->addText($firma['ciudad'].$fecha['fecha'], ['bold' => true, 'italic' => true], ['alignment' => 'right']);

// Agregar dirección del remitente
$section->addText("Señores:", ['bold' => true], $paragraphStyle1);
$section->addText($importadora, ['bold' => true],  $paragraphStyle1);
$section->addText($representante, ['bold' => true], $paragraphStyle1);
$section->addText("Presente.-", ['bold' => true, 'underline' => 'single'], $paragraphStyle1);
$section->addTextBreak();


// Saludo
$section->addText("Un gusto saludarle por este medio.", null, $paragraphStylel);
$section->addTextBreak();
// Cuerpo de la carta
$section->addText("Nos complace presentar nuestra empresa de transporte internacional de carga, una compañía con una sólida trayectoria en el mercado y con una fuerte orientación de familia que guía nuestro enfoque en el servicio al cliente.", null, $paragraphStyle);
//$section->addTextBreak();
$section->addText("Desde nuestros inicios, hemos estado comprometidos en ofrecer un servicio de calidad y personalizado, que se adapte a las necesidades de nuestros clientes. ", null, $paragraphStyle);
//$section->addTextBreak();
$section->addText("Nos enorgullece contar con un equipo de profesionales altamente capacitados y con amplia experiencia en el sector logístico, lo que nos permite brindar soluciones eficientes y seguras para la gestión de cargas internacionales en importaciones y exportaciones como:", null, $paragraphStyle);
//$section->addTextBreak();
// Lista con viñetas
$items = [
    "TRANSPORTE MARÍTIMO DESDE CUALQUIER PARTE DEL MUNDO (CONTENEDORES Y CARGA SUELTA)",
    "TRANSPORTE AÉREO DESDE CUALQUIER PARTE DEL MUNDO",
    "TRANSPORTE TERRESTRE HASTA SUS ALMACENES",
    "TRANSPORTE MULTIMODAL",
    "CARGA DE PROYECTOS",
    "SEGURO DE CARGA",
    "GIROS A PROVEEDORES DEL EXTERIOR"
];

foreach ($items as $item) {
    $section->addListItem($item, 0, ['bold' => true, 'spaceBefore' => 0, 'spaceAfter' => 0,'name' => 'Arial', 'size' => 8 ],  ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED]);
}
//$section->addTextBreak();
$section->addText("Nos esforzamos por mantener una comunicación cercana y transparente con nuestros clientes, entendemos que cada carga es única y requiere de una atención personalizada. Además, nos caracterizamos por nuestra ética de trabajo y compromiso, implementando políticas que aseguran una gestión responsable.", null, $paragraphStyle);
//$section->addTextBreak();
$section->addText("Confiamos en que nuestra empresa pueda ser de su agrado y satisfacer sus necesidades logísticas. Estamos a su disposición para cualquier consulta o solicitud de información adicional.", null, $paragraphStyle);
//$section->addTextBreak();
$section->addText("Nos complace presentar nuestra empresa de transporte internacional de carga, una compañía con una sólida trayectoria en el mercado y con una fuerte orientación de familia que guía nuestro enfoque en el servicio al cliente.", null, $paragraphStyle);
//$section->addTextBreak();
$section->addText("Saludos cordiales.", null, $paragraphStyle);
$section->addTextBreak();


// Despedida
$section->addText("Atentamente,", null);
$section->addTextBreak();
$section->addText($firma['trabajador'], ['bold' => true], $paragraphStyle1);
$section->addText($firma['cargo'], ['bold' => true], $paragraphStyle1);
$section->addText($firma['email'], ['bold' => true], $paragraphStyle1);
$section->addText($firma['celular'], ['bold' => true], $paragraphStyle1);
$section->addText($firma['telefono'], ['bold' => true], $paragraphStyle1);
$section->addText($firma['direccion'], ['bold' => true, 'name' => 'Arial', 'size' => 8 ], $paragraphStyle1);

// Guardar y descargar
$filename = "Carta.docx";
$objWriter = IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save($filename);

header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Transfer-Encoding: binary");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Expires: 0");
header("Pragma: public");
readfile($filename);

unlink($filename);
exit;
?>

