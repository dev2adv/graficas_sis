<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once "Conexion.php";
$usuario = $_GET['usuario'];
$mes = $_GET['mes']; // Default to '202501' if not provided
if (!isset($_GET['usuario'])) {
    die("Error: No se recibió el usuario.");
}
try {
    $conn = CConexion::ConexionDB();
    $stmt = $conn->prepare(" SELECT distinct TO_CHAR(a.fllegada, 'YYYYMM') as periodo, a.id_suc  as tipo, count(*) cantidad
                                 FROM 
                                 embarqueventas a, usuarios b, trabajador c
                                 WHERE 
                                 a.vendedor=b.us_email and b.per_id=c.id
                                 --and TO_CHAR(a.fllegada, 'YYYYMM') = '$mes'
                                 and a.id_suc=(select sucursal from usuarios a, trabajador b
                                 where a.per_id=b.id and a.us_email='$usuario')
                                 GROUP BY 
                                 TO_CHAR(a.fllegada, 'YYYYMM'),a.id_suc
                                  ORDER BY  1 asc");


    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Asegurar que 'casos' esté correctamente asignado en cada fila
    foreach ($result as &$row) {
        if (!array_key_exists('cantidad', $row)) {
            $row['cantidad'] = 0;  // Si no existe, asignar 0
            } else {
                $row['cantidad'] = (int)$row['cantidad']; // Convertir a número entero
            }
    }   
    
    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
    exit;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>