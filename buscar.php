<?php
$conexion = new mysqli("localhost", "usuario", "contraseña", "base_de_datos");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$termino = $_GET['term'];
$sql = "SELECT pais_nombre FROM lista_paises WHERE pais_nombre LIKE '%" . $termino . "%'";
$resultado = $conexion->query($sql);

$paises = [];
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $paises[] = $fila['pais_nombre'];
    }
}

echo json_encode($paises);
?>
