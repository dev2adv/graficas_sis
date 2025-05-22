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
    
    $con=CConexion::ConexionDB();

    $resultados= [];
    //$row=[];

    $sqls =" SELECT distinct d.sucursal
            FROM embarqueventas a
            INNER JOIN usuarios b ON a.vendedor = b.us_email
            INNER JOIN trabajador c ON b.per_id = c.id
            INNER JOIN cat_sucursal d ON c.sucursal = d.id
            WHERE 
            TO_CHAR(a.fllegada, 'YYYYMM') = '$ges'
            ORDER BY 1 ASC";
    $stmts = $con->prepare($sqls);
    $stmts->execute();
    $results = $stmts->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($results as $rows => $suc) {

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
    


            $sql = "SELECT 	c.id, c.trabajador, 
                    ROUND(SUM(a.totalp)::numeric, 2) AS profit, 
                    SUM(a.tcontable) AS ttcontable, 
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
                    AND d.sucursal = '".$suc['sucursal']."'
                    GROUP BY d.sucursal,c.trabajador, c.id
                    ORDER BY d.sucursal ASC";
            //var_dump($sql);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //var_dump($resultados);
            $html="";
            $i=0;

            echo '<tr > 
                    <td colspan="12" style="text-align: center; font-weight: bold;" >'.' '.' </td>
                  </tr>
                <tr class="table-secondary"> 
                    <td colspan="12" style="text-align: center;  font-weight: bold; font-size: 18;" >'.$suc['sucursal'].' </td>
                  </tr>
                <tr class="table-danger">
                    <th style="text-align: center;">VENDEDOR</th>
                    <th style="text-align: center;">TOTAL PROFIT</th>
                    <th style="text-align: center;">TOTAL TCONTABLE</th>
                    <th style="text-align: center;">CANTIDAD CONTENEDORES</th>
                    <th style="text-align: center;">MARITIMO</th>
                    <th style="text-align: center;">AEREO</th>
                    <th style="text-align: center;">TERRESTRE</th>
                    <th style="text-align: center;">OTROS</th>
                    <th style="text-align: center;">20 DRY</th>
                    <th style="text-align: center;">40 DRY</th>
                    <th style="text-align: center;">40 HC</th>
                    <th style="text-align: center;">OTROS</th>
                    
                </tr>';

            foreach ($resultados as $row => $value) {
                echo '<tr data-id="'. $value['id'] .'" data-vendedor="'. $value['trabajador'] .'"><td >' . $value['trabajador'] . '</td>
                <td style="text-align: center;">' . $value['profit'] . '</td>
                <td style="text-align: center;">' . $value['ttcontable'] . '</td>
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
                $ventaTotal = $ventaTotal + $value['profit'];
                $ttcontable = $ttcontable + $value['ttcontable'];
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
                
                <td style="text-align: right; font-weight: bold;">' ."TOTALES " . '</td><td style="text-align: center; font-weight: bold;">'  . $ventaTotal . '</td>
                <td style="text-align: center; font-weight: bold;">' . $ttcontable . '</td><td style="text-align: center; font-weight: bold;">' . $nrocont . '</td>
                <td style="text-align: center; font-weight: bold;">' . $ttipot . '</td><td style="text-align: center; font-weight: bold;">' . $ttipot1 . '</td>
                <td style="text-align: center; font-weight: bold;">' . $ttipot2 . '</td><td style="text-align: center; font-weight: bold;">' . $ttipot3 . '</td>
                <td style="text-align: center; font-weight: bold;">' . $ctipot. '</td><td style="text-align: center; font-weight: bold;">' . $ctipot1 . '</td>
                <td style="text-align: center; font-weight: bold;">' . $ctipot2. '</td><td style="text-align: center; font-weight: bold;">' . $ctipot3.  '</td>
                </tr>';
    
        }

    }
    
    
?>