<?php

require_once "Conexion.php";
//$con=CConexion::ConexionDB();

$pdo = CConexion::ConexionDB();
/*var_dump($_GET);
var_dump(" * ");
var_dump($_POST);*/
$keyword = '%'.$_POST['palabra'].'%';
//var_dump($keyword);
$sql = "select proveedor as agente from cat_proveedor  where proveedor LIKE UPPER(:keyword) and estado='A' ORDER BY 1 ASC LIMIT 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
//var_dump($sql);
$lista = $query->fetchAll();
//var_dump($lista);
foreach ($lista as $milista) {
	// Colocaremos negrita a los textos
	$agente = str_replace($_POST['palabra'], '<b>'.$_POST['palabra'].'</b>', $milista['agente']);
	// Aquì, agregaremos opciones
    echo '<li onclick="set_item(\''.str_replace("'", "\'", $milista['agente']).'\')">'.$agente.'</li>';
}

?>