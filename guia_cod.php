<?php
include_once("Conexion.php");
//print_r($_GET);
$area = $_GET['area'];
// Obtener los datos
function obtenerTrabajadoresGerencia($parea) {
    $con=CConexion::ConexionDB();
    $query = $con->query("  SELECT ROW_NUMBER() OVER (ORDER BY z.ciudad, z.sucursal, z.trabajador) AS nro, z.* from (
                            SELECT a.trabajador, a.cargo, a.area, a.email, a.celular, c.sucursal, d.ciudad
                            FROM trabajador a
                            LEFT JOIN usuarios b ON a.id = b.per_id
                            LEFT JOIN cat_sucursal c ON a.sucursal = c.id
                            LEFT JOIN cat_ciudad d ON c.ciu_id = d.id
                            WHERE a.estado = 'A' 
                            AND a.area = '$parea'
                            AND b.per_id IS NULL  
                            UNION
                            SELECT a.trabajador, a.cargo, a.area, a.email, a.celular, c.sucursal, d.ciudad
                            FROM trabajador a
                            LEFT JOIN usuarios b ON a.id = b.per_id
                            LEFT JOIN cat_sucursal c ON a.sucursal = c.id
                            LEFT JOIN cat_ciudad d ON c.ciu_id = d.id
                            WHERE a.estado = 'A' 
                            AND a.area = '$parea'
                            AND b.per_id IS NOT NULL
                            union
                            SELECT a.trabajador, a.cargo, a.area, a.email, a.celular, c.sucursal, d.ciudad
                            FROM trabajador a
                            LEFT JOIN usuarios b ON a.id = b.per_id
                            LEFT JOIN cat_sucursal c ON a.sucursal = c.id
                            LEFT JOIN cat_ciudad d ON c.ciu_id = d.id
                            WHERE a.estado = 'A' and a.id = 44
                            AND 'RRHH' = '$parea') z
                            ORDER BY z.ciudad, z.sucursal, z.trabajador asc ");
    return $query->fetchAll(PDO::FETCH_ASSOC); // Retorna un array con los resultados
}
$resultados = obtenerTrabajadoresGerencia($area);
header('Content-Type: application/json'); // Define el tipo de contenido
echo json_encode($resultados);


// Para visualizar los resultados (depuración)
//print_r($resultados);

?>