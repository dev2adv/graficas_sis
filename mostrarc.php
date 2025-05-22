<?php
require_once "Conexion.php";
//$con=CConexion::ConexionDB();

$pdo = CConexion::ConexionDB();
/*var_dump($_GET);
var_dump(" * ");
var_dump($_POST);*/

//lista consignatarios
$keywordc = '%'.$_POST['palabrac'].'%';
//var_dump($keywordc);
$sqlc = "select importadora from clientes where importadora LIKE UPPER(:keywordc) ORDER BY 1 ASC LIMIT 10";
$queryc = $pdo->prepare($sqlc);
$queryc->bindParam(':keywordc', $keywordc, PDO::PARAM_STR);
$queryc->execute();
//var_dump($sql);
$listac = $queryc->fetchAll();
//var_dump($listac);
foreach ($listac as $milistac) {
	// Colocaremos negrita a los textos
	$consig = str_replace($_POST['palabrac'], '<b>'.$_POST['palabrac'].'</b>', $milistac['importadora']);
	// Aquì, agregaremos opciones
    echo '<li onclick="set_itemc(\''.str_replace("'", "\'", $milistac['importadora']).'\')">'.$consig.'</li>';
}

?>