<?php
    //require_once('./config.php');
    include_once("Conexion.php");
    include('login.php');
    //var_dump($_POST);
    //var_dump($_GET);
    if (isset($_GET['ges'])) {

    $ges=$_GET['ges'];
    $usuario = $_SESSION['usuario'];
    //var_dump($ges);
    $ventaTotal = 0;
    $ttcontable = 0;
    $nrocont = 0;
    $ttipot = 0;
    $ttipot1 = 0;
    $ttipot2 = 0;
    $ttipot3 = 0;
    $ctipot = 0;
    $ctipot1 = 0;
    $ctipot2 = 0;
    $ctipot3 = 0;

    $con=CConexion::ConexionDB();

    $resultados= [];
    //$row=[];

    $sql = "SELECT 	     c.trabajador, 
			COUNT(*) AS casos,
            SUM(a.ventat) AS venta, 
            SUM(a.tccontenedor) AS nro_contenedores,
            SUM(CASE WHEN a.ttransporte = 'MARÍTIMO' THEN 1 * a.tccontenedor ELSE 0 END) AS ttipot, 
            SUM(CASE WHEN a.ttransporte = 'AEREO' THEN 1 * a.tccontenedor ELSE 0 END) AS ttipot1,
            SUM(CASE WHEN a.ttransporte = 'TERRESTRE' THEN 1 * a.tccontenedor ELSE 0 END) AS ttipot2,
            SUM(CASE WHEN COALESCE(a.ttransporte,'XX') NOT IN ('MARÍTIMO', 'AEREO', 'TERRESTRE') THEN 1 * a.tccontenedor ELSE 0 END) AS ttipot3,
            SUM(CASE WHEN e.tcontenedor = '20 DRY' THEN 1 * e.ccontenedor ELSE 0 END) AS ctipot, 
            SUM(CASE WHEN e.tcontenedor = '40 DRY' THEN 1  * e.ccontenedor  ELSE 0 END) AS ctipot1,
            SUM(CASE WHEN e.tcontenedor = '40 HC' THEN 1  * e.ccontenedor  ELSE 0 END) AS ctipot2,
            SUM(CASE WHEN COALESCE(e.tcontenedor,'DD') NOT IN ('40 DRY','40 HC','20 DRY') THEN 1  * e.ccontenedor  ELSE 0 END) AS ctipot3,
			d.sucursal
            FROM 
            embarqueventas a
			INNER JOIN embarqueventas_det e ON a.nro = e.idnro
            INNER JOIN usuarios b ON a.vendedor = b.us_email
            INNER JOIN trabajador c ON b.per_id = c.id
			INNER JOIN cat_sucursal d ON c.sucursal = d.id
            WHERE 
            TO_CHAR(a.fllegada, 'YYYYMM') = '$ges'
			and c.sucursal=(select sucursal from usuarios a, trabajador b
			where a.per_id=b.id and a.us_email='$usuario')
            GROUP BY 
            d.sucursal,c.trabajador
			ORDER BY c.trabajador ASC";
    //var_dump($sql);
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($resultados);
    $html="";
    $i=0;
    foreach ($resultados as $row => $value) {
        echo '<tr>
        <td                            >' . $value['trabajador'] . '</td>
        <td style="text-align: center;">' . $value['casos'] . '</td>
        <td style="text-align: center;">' . $value['venta'] . '</td>
        <td style="text-align: center;">' . $value['nro_contenedores'] . '</td>
        <td style="text-align: center;">' . $value['ttipot'] . '</td>
        <td style="text-align: center;">' . $value['ttipot1'] . '</td>
        <td style="text-align: center;">' . $value['ttipot2']. '</td>
        <td style="text-align: center;">' . $value['ttipot3'] . '</td>
        <td style="text-align: center;">' . $value['ctipot']. '</td>
        <td style="text-align: center;">' . $value['ctipot1']. '</td>
        <td style="text-align: center;">' . $value['ctipot2']. '</td>
        <td style="text-align: center;">' . $value['ctipot3']. '</td>
        </tr style="text-align: center;">';
        $ventaTotal = $ventaTotal + $value['casos'];
        $ttcontable = $ttcontable + $value['venta'];
        $nrocont = $nrocont + $value['nro_contenedores'] ;
        $ttipot = $ttipot + $value['ttipot'];
        $ttipot1 = $ttipot1 + $value['ttipot1'];
        $ttipot2 = $ttipot2 + $value['ttipot2'];
        $ttipot3 = $ttipot3 + $value['ttipot3'];
        $ctipot = $ctipot + $value['ctipot'];
        $ctipot1 = $ctipot1 + $value['ctipot1'];
        $ctipot2 = $ctipot2 + $value['ctipot2'];
        $ctipot3 = $ctipot3 + $value['ctipot3'];
        
    }
        echo '<tr class="table-danger">
        <td style="text-align: right; font-weight: bold;">' . "TOTALES " . '</td><td style="text-align: center; font-weight: bold;">'  . $ventaTotal . '</td>
        <td style="text-align: center; font-weight: bold;">' . $ttcontable . '</td><td style="text-align: center; font-weight: bold;">' . $nrocont . '</td>
        <td style="text-align: center; font-weight: bold;">' . $ttipot . '</td><td style="text-align: center; font-weight: bold;">' . $ttipot1 . '</td>
        <td style="text-align: center; font-weight: bold;">' . $ttipot2 . '</td><td style="text-align: center; font-weight: bold;">' . $ttipot3 . '</td>
        <td style="text-align: center; font-weight: bold;">' . $ctipot. '</td><td style="text-align: center; font-weight: bold;">' . $ctipot1 . '</td>
        <td style="text-align: center; font-weight: bold;">' . $ctipot2. '</td><td style="text-align: center; font-weight: bold;">' . $ctipot3.  '</td>
        </tr>';
    
    

    }
    
    
?>