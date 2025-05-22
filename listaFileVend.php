<?php
    //require_once('./config.php');
    include_once("Conexion.php");
    include('login.php');
    //var_dump($_POST);
    var_dump($_GET);
    if (isset($_GET['id'])) {

    $pid=$_GET['id']; 
    $per=$_GET['periodo'];
    $usuario = $_SESSION['usuario'];
    //var_dump($ges);
    
    $con=CConexion::ConexionDB();

    $resultados= [];
    //$row=[];

    $sqls = "SELECT DISTINCT d.sucursal
    FROM embarques a
    INNER JOIN usuarios b ON a.vendedor = b.us_email
    INNER JOIN trabajador c ON b.per_id = c.id
    INNER JOIN cat_sucursal d ON c.sucursal = d.id
    WHERE TO_CHAR(a.fllegada, 'YYYYMM') = '$per'
    AND c.id = $pid
    ORDER BY 1 ASC";

    $stmts = $con->prepare($sqls);
    //$stmts->bindParam(':per', $per, PDO::PARAM_STR);
    //$stmts->bindParam(':pid', $pid, PDO::PARAM_INT);
    $stmts->execute();
    //var_dump($stmts);
    $results = $stmts->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($results);
    foreach ($results as $rows => $suc) {
        //echo "dentro del foreach";
        $ncasos = 0;
        $nrocont = 0;
        $ventaT = 0;
        $ventaTotal = 0;
        $compraT = 0;
        $totalP = 0;
        $ttcontable = 0;
    


            $sql = "SELECT 	c.id, c.trabajador,a.ro, a.servicio, a.tipot, a.naviera, a.proveedor, a.consignatario,
                    a.mbl, a.ncontenedor, a,tcontenedor, a.ccontenedor, a.mercancia, a.porigen, a.fsalida,
                    a.pllegada, a.fllegada, a.venta, a.ventat, a.comprat, a.totalp, a.tcontable, a.obs, a.nro
                    FROM embarques a
                    INNER JOIN usuarios b ON a.vendedor = b.us_email
                    INNER JOIN trabajador c ON b.per_id = c.id
                    INNER JOIN cat_sucursal d ON c.sucursal = d.id
                    WHERE TO_CHAR(a.fllegada, 'YYYYMM') = '$per'
                    AND d.sucursal = '".$suc['sucursal']."'
                    AND c.id=$pid
                    ORDER BY a.fllegada ASC";
            //var_dump($sql);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            var_dump($resultados);
            $html="";
            $i=0;
            var_dump("antes de las filas");
            echo '<tr > 
                    <td colspan="22" style="text-align: center; font-weight: bold;" >'.' '.' </td>
                  </tr>
                <tr class="table-secondary"> 
                    <td colspan="22" style="text-align: center;  font-weight: bold; font-size: 18;" >'.$suc['sucursal'].' </td>
                  </tr>
                <tr class="table-danger">
                    <th style="text-align: center;">RO</th>
                    <th style="text-align: center;">SERVICIO</th>
                    <th style="text-align: center;">TIPO DE TRANSPORTE</th>
                    <th style="text-align: center;">NAVIERA</th>
                    <th style="text-align: center;">PROVEEDOR</th>
                    <th style="text-align: center;">CONSIGNATARIO</th>
                    <th style="text-align: center;">MBL / BOOKING</th>
                    <th style="text-align: center;">NUMERO DE CONTENEDOR</th>
                    <th style="text-align: center;">TIPO DE CONTENEDOR</th>
                    <th style="text-align: center;">CANTIDAD DE CONTENEDOR</th>
                    <th style="text-align: center;">MERCANCIA O PRODUCTO</th>
                    <th style="text-align: center;">PUERTO ORIGEN</th>
                    <th style="text-align: center;">FECHA SALIDA</th>
                    <th style="text-align: center;">PUERTO LLEGADA</th>
                    <th style="text-align: center;">FECHA LLEGADA</th>
                    <th style="text-align: center;">VENTA</th>
                    <th style="text-align: center;">VENTA TOTAL</th>
                    <th style="text-align: center;">COMPRA TOTAL</th>
                    <th style="text-align: center;">TOTAL PROFIT</th>
                    <th style="text-align: center;">T CONTABLE</th>
                    <th style="text-align: center;">OBSERVACIONES</th>
                    <th style="text-align: center;">NRO</th>
                </tr>';

            foreach ($resultados as $row => $value) {
                echo '<tr>
                        <td style="text-align: center;">' . $value['ro'] . '</td>
                        <td style="text-align: center;">' . $value['servicio'] . '</td>
                        <td style="text-align: center;">' . $value['tipot'] . '</td>
                        <td style="text-align: center;">' . $value['naviera'] . '</td>
                        <td style="text-align: center;">' . $value['proveedor'] . '</td>
                        <td style="text-align: center;">' . $value['consignatario']. '</td>
                        <td style="text-align: center;">' . $value['mbl'] . '</td>
                        <td style="text-align: center;">' . $value['ncontenedor']. '</td>
                        <td style="text-align: center;">' . $value['tcontenedor']. '</td>
                        <td style="text-align: center;">' . $value['ccontenedor']. '</td>
                        <td style="text-align: center;">' . $value['mercancia']. '</td>
                        <td style="text-align: center;">' . $value['porigen']. '</td>
                        <td style="text-align: center;">' . $value['fsalida']. '</td>
                        <td style="text-align: center;">' . $value['pllegada']. '</td>
                        <td style="text-align: center;">' . $value['fllegada']. '</td>
                        <td style="text-align: center;">' . $value['venta']. '</td>
                        <td style="text-align: center;">' . $value['ventat']. '</td>
                        <td style="text-align: center;">' . $value['comprat']. '</td>
                        <td style="text-align: center;">' . $value['totalp']. '</td>
                        <td style="text-align: center;">' . $value['tcontable']. '</td>
                        <td style="text-align: center;">' . $value['obs']. '</td>
                        <td style="text-align: center;">' . $value['nro']. '</td>
                      </tr style="text-align: center;">';
                $ncasos = $ncasos + 1;
                $nrocont = $nrocont + $value['ccontenedor'] ;
                $ventaT = $ventaT + $value['venta'];
                $ventaTotal = $ventaTotal + $value['ventat'];
                $compraT = $compraT + $value['comprat'];
                $totalP = $totalP + $value['totalp'];
                $ttcontable = $ttcontable + $value['tcontable'];
            }
                echo '<tr class="table-danger">
                        <td style="text-align: right; font-weight: bold;">' ."Nro. Files " . '</td>
                        <td style="text-align: center; font-weight: bold;">'  . $ncasos . '</td>
                        <td colspan="7" style="text-align: right; font-weight: bold;">' ."TOTALES " . '</td>
                        <td style="text-align: center; font-weight: bold;">' . $nrocont . '</td>
                        <td colspan="5" style="text-align: center; font-weight: bold;"></td>
                        <td style="text-align: center; font-weight: bold;">' . $ventaT . '</td>
                        <td style="text-align: center; font-weight: bold;">' . $ventaTotal . '</td>
                        <td style="text-align: center; font-weight: bold;">' . $compraT . '</td>
                        <td style="text-align: center; font-weight: bold;">' . $totalP . '</td>
                        <td style="text-align: center; font-weight: bold;">' . $ttcontable. '</td>
                        <td colspan="2" style="text-align: center; font-weight: bold;"></td>
                     </tr>';
    
        }

    }
    
    
?>

