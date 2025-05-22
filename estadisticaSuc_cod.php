<?php

require_once "Conexion.php";
$usuario = $_GET['usuario'];
//echo "Usuario recibido: " . $usuario;
try {
    $conn = CConexion::ConexionDB();
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //var_dump("estadistica1.php");
    /*$stmt = $conn->prepare("SELECT d.sucursal, COUNT(h.numven) AS total_ventas, COALESCE(SUM(h.montoven), 0) AS monto_total
    FROM cat_sucursal d
    LEFT JOIN (
        SELECT c.trabajador, d.sucursal AS sucursal, COUNT(*) AS numven, SUM(a.ventat) AS montoven
        FROM embarques a
        INNER JOIN usuarios b ON a.vendedor = b.us_email
        INNER JOIN trabajador c ON b.per_id = c.id
        INNER JOIN cat_sucursal d ON c.sucursal = d.id
        WHERE TO_CHAR(a.fllegada, 'YYYYMM') = '202503'
        GROUP BY d.sucursal, c.trabajador) h 
        ON d.sucursal = h.sucursal
        GROUP BY d.sucursal");*/

        $stmt = $conn->prepare(" SELECT distinct TO_CHAR(a.fllegada, 'YYYYMM') as periodo, count(*) casos
                                 FROM 
                                 embarqueventas a, usuarios b, trabajador c
                                 WHERE 
                                 TO_CHAR(a.fllegada, 'YYYYMM') > '202412'
                                 and a.vendedor=b.us_email and b.per_id=c.id
                                 and a.id_suc=(select sucursal from usuarios a, trabajador b
                                 where a.per_id=b.id and a.us_email='$usuario')
                                 GROUP BY 
                                 TO_CHAR(a.fllegada, 'YYYYMM')
                                  ORDER BY  1 asc");


    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($result);
    echo json_encode($result);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>