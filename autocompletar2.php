<?php

require_once "Conexion.php";
$con=CConexion::ConexionDB();
echo "en el autocompletar2 ";
var_dump($_GET);
$termino = $_GET['term'];
$sql = "select agente from cat_agente_prov where agente LIKE ? ORDER BY 1 ASC LIMIT 10";
$resultado = $con->query($sql);

$paises = [];
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $paises[] = $fila['pais_nombre'];
    }
}

echo json_encode($paises);


?>




