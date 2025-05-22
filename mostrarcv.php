<?php
session_start();
require_once "Conexion.php";
//$con=CConexion::ConexionDB();

$pdo = CConexion::ConexionDB();
var_dump($_GET);
var_dump(" * ");
var_dump($_POST);
var_dump($_SESSION['usuario']);
$usuario = $_SESSION['usuario'];
//lista consignatarios
$keywordc = '%'.$_POST['palabracl'].'%';
//var_dump($keywordc);
$sqlc = "select DISTINCT UPPER(consignatario) AS cliente FROM public.embarques where UPPER(consignatario) LIKE UPPER(:keywordc) and vendedor = '$usuario' ORDER BY 1 ASC LIMIT 50";
//select distinct UPPER(consignatario) AS CLIENTE  FROM public.embarques where UPPER(consignatario) LIKE UPPER('%ca%') and vendedor='YMIsrael' ORDER BY 1 ASC
$queryc = $pdo->prepare($sqlc);
$queryc->bindParam(':keywordc', $keywordc, PDO::PARAM_STR);
$queryc->execute();
//var_dump($sql);
$listac = $queryc->fetchAll();

// Verificar si hay datos
    if (count($listac) > 0) {
        foreach ($listac as $milistac) {
			// Colocaremos negrita a los textos
			$consig = str_replace($_POST['palabracl'], '<b>'.$_POST['palabracl'].'</b>', $milistac['cliente']);
			// Aquì, agregaremos opciones
			echo '<li onclick="set_itemc(\''.str_replace("'", "\'", $milistac['cliente']).'\')">'.$consig.'</li>';
		}
    } else {
        echo "No hay datos en la consulta.";
    }





?>