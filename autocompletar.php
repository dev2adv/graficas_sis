<?php
require_once "Conexion.php";
$con = CConexion::ConexionDB();
$search = $_POST['proveedor'];

$query = "SELECT * FROM embarques WHERE proveedor LIKE ? ORDER BY proveedor ASC LIMIT 10";
$resultado = $con->prepare($query);
$resultado->execute([$search . '%']);
$html = "";

while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
    $html .= "<li onclick=\"mostrar('" . $row["proveedor"]. "')\">" . $row["proveedor"]. "</li>";
}

echo json_encode($html);
?>
