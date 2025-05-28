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
if (!isset($_GET['mes'])) {
    die("Error: No se recibió el mes.");
}
try {
    $conn = CConexion::ConexionDB();
    $stmt = $conn->prepare("SELECT to_char(a.fllegada,'yyyymm') as periodo,c.trabajador as tipo,count(*) as cantidad
                            from embarqueventas a,usuarios b,trabajador c
                            where a.vendedor=b.us_email and b.per_id=c.id
                            and TO_CHAR(a.fllegada, 'YYYYMM') = '$mes'
                            and a.id_suc=(select n.sucursal from usuarios m,trabajador n
                            where m.per_id=n.id 
                            and m.us_email='$usuario')
                            group by 
                            to_char(a.fllegada,'yyyymm'),c.trabajador
                            order by 
                            1,2 ASC");
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
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}


?>