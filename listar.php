<?php
    //require_once('./config.php');
    include_once("Conexion.php");
    include('login.php');

    if (isset($_GET['mes'])) {

        $mes=$_GET['mes'];
  
    $usuario = $_SESSION['usuario'];

    
    $ventaTotal = 0;
    $contenedoresTotal = 0;
    $compraTotalT = 0;
    $ventaSTotal = 0;
    $compraSTotal = 0;
    $ventaTotalT = 0;
    $profitTotal = 0;
    $tcontableTotal = 0;

    $con=CConexion::ConexionDB();
    $consulta="SELECT 
    a.ro, a.servicio, a.ttransporte, a.naviera, a.proveedor, a.consignatario,
    a.mbl,
    (SELECT STRING_AGG(ncontenedor, ', ') 
     FROM embarqueventas_det b 
     WHERE b.idnro=a.nro) AS ncontenedor,
    (SELECT STRING_AGG(tcontenedor, ', ') 
     FROM embarqueventas_det b 
     WHERE b.idnro=a.nro) AS tcontenedor,
    a.tccontenedor,
    (SELECT STRING_AGG(mercancia, ', ') 
     FROM embarqueventas_det b 
     WHERE b.idnro=a.nro) AS mercancia,
    a.porigen, a.fsalida, a.pllegada, a.fllegada, 
    a.ventat, a.comprat, a.totalp, a.tcontable, 
    a.obs, a.nro
    FROM embarqueventas a
    WHERE a.vendedor = '$usuario'
    AND CAST(CONCAT(CAST(EXTRACT(year FROM fllegada) AS INT), '', LPAD(CAST(EXTRACT(MONTH FROM fllegada) AS INT)::text, 2, '0')) AS INT)='$mes'
    ORDER BY 14 ASC";
    $resultado=$con->prepare($consulta);
    $resultado->execute();
    //$datos = $resultado->fetchAll();
    //$array[] = array('VENTA' => 0, 'CANTIDAD DE CONTENEDOR' => 0, 'COMPRA TOTAL' => 0, 'VENTA SEGURO' => 0,'COMPRA SEGURO' => 0, 'VENTA TOTAL' => 0, 'TOTAL PROFIT' => 0, 'T CONTABLE' => 0, 'RO' => 0,'SHIPPER PROFORM INVOICE' => 0, 'MBL' => 0, 'CONSIGNATARIO' => 0, 'NUMERO DE CONTENEDOR' => 0, 'TIPO DE CONTENEDOR' => 0, 'MERCANCIA O PRODUCTO' => 0, 'PUERTO ORIGEN' => 0, 'PUERTO LLEGADA' => 0, 'FECHA SALIDA' => 0, 'FECHA LLEGADA' => 0, 'INVOICE DE LA CARGA' => 0, 'TIPO DE TRANSPORTE' => 0, 'NAVIERA' => 0, 'OBSERVACIONES' => 0 , 'PROVEEDOR' => 0 );

    $html="";

    
    while($row = $resultado ->fetch(PDO::FETCH_ASSOC)){
        $mesD = date("n", strtotime($row['fllegada']));
        if($mesD = $mes)
        {
            $html .= "<tr>
                <th>".$row['ro']."</th>
                <th>".$row['servicio']."</th>
                <th>".$row['ttransporte']."</th>
                <th>".$row['naviera']."</th>
                <th>".$row['proveedor']."</th>
                <th>".$row['consignatario']."</th>
                <th>".$row['mbl']."</th>
                <th>".$row['ncontenedor']."</th>
                <th>".$row['tcontenedor']."</th>
                <th>".$row['tccontenedor']."</th>
                <th>".$row['mercancia']."</th>
                <th>".$row['porigen']."</th>
                <th>".$row['fsalida']."</th>
                <th>".$row['pllegada']."</th>
                <th>".$row['fllegada']."</th>
                <th>".$row['ventat']."</th>
                <th>".$row['comprat']."</th>
                <th>".$row['totalp']."</th>
                <th>".$row['tcontable']."</th>
                <th>".$row['obs']."</th>
                <th>".$row['nro']."</th> 
                <th>
                    <i class='btn btn-outline-primary' onclick=\"modal('".$row['nro']."')\"   >
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                    <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                    <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z'/>
                    </svg></i>
 
                </th>
                <th>
                    <i onclick=\"borrar('".$row['nro']."')\" class='btn btn-outline-danger'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 18 18'>
                    
                    <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0'/>
                    </svg></i>
                </th>
                
            </tr>";

            //$ventaTotal = $ventaTotal + $row['venta'];
            $contenedoresTotal = $contenedoresTotal + $row['tccontenedor'];
            $compraTotalT = $compraTotalT + $row['comprat'] ;
            //$ventaSTotal = $ventaSTotal + $row['ventat'];
            $compraSTotal = $compraSTotal + $row['comprat'];
            $ventaTotalT = $ventaTotalT + $row['ventat'];
            $profitTotal = $profitTotal + $row['totalp'];
            $tcontableTotal = $tcontableTotal + $row['tcontable'];
        }
    }

    $html .= "
            <tr class='table-danger'>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>$contenedoresTotal</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th> $ventaTotalT</th>
                <th> $compraTotalT</th>
                <th> $profitTotal</th>
                <th> $tcontableTotal</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                
            </tr>";

    

    echo json_encode($html);
    // var_dump($datos);
    // return $datos;
}
?>