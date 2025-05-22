<?php
    require_once"Conexion.php";
    include('login.php');
    //include('cabecera.php');
    $con=CConexion::ConexionDB();
    //var_dump($_POST);
    //var_dump($_GET);
    if (isset($_POST)) {
        //echo "parece q no es null  ";
        $impnom=isset($_POST['impnom'])?$_POST['impnom']:'';
        $fecha_registro = date("Y-m-d H:i:s");
        $ro  =isset( $_POST['ro'])?$_POST['ro']:'';
        $shipper = isset($_POST['shipper'])?$_POST['shipper']:'';
        $mbl =isset( $_POST['mbl'])?$_POST['mbl']:'';
        $proveedor = isset($_POST['proveedor'])?$_POST['proveedor']:'';
        $consignatario = isset($_POST['consig'])?$_POST['consig']:'';
        $numeroContenedor = isset($_POST['contenedor'])?$_POST['contenedor']:'';
        $tipoContenedor =isset( $_POST['tipo'])?$_POST['tipo']:[];
        $tipoContenedor = isset($_POST['tipo']) ? $_POST['tipo'] : []; 
        if (is_array($tipoContenedor)) { 
            $tipoContenedorStr = implode(", ", $tipoContenedor); 
        } else { 
            $tipoContenedorStr = $tipoContenedor; 
        }
        $cantidadContenedor =isset( $_POST['ccontenedor'])?$_POST['ccontenedor']:0;
        $mercancia = isset($_POST['producto'])?$_POST['producto']:'';
        $pOrigen = isset($_POST['origen'])?$_POST['origen'] : [];
        if (is_array($pOrigen)) { 
            $pOrigenes = implode(", ", $pOrigen); 
        } else { 
            $pOrigenes = $pOrigen; 
        }
        $pLlegada = isset($_POST['llegada'])?$_POST['llegada']:[];
        if (is_array($pLlegada)) { 
            $pLlegadas = implode(", ", $pLlegada); 
        } else { 
            $pLlegadas = $pLlegada; 
        }
        $fSalida = isset($_POST['salida'])?$_POST['salida']:'';
        $fLlegada = isset($_POST['Fllegada'])?$_POST['Fllegada']:'';
        $invoice = isset($_POST['invoice'])?$_POST['invoice']:'';
        $venta = isset($_POST['venta'])?$_POST['venta']:0;
        $compraT = isset($_POST['compra'])?$_POST['compra']:0;
        $ventaS = isset($_POST['vseguro'])?$_POST['vseguro']:0;
        $compraS = isset($_POST['cseguro'])?$_POST['cseguro']:0;
        $ventaT = isset($_POST['vtotal'])?$_POST['vtotal']:0;
        $totalP = isset($_POST['profit'])?$_POST['profit']:0;
        $Tcontable = isset($_POST['tcontable'])?$_POST['tcontable']:0;
        $tipoTrans = isset($_POST['transporte'])?$_POST['transporte']:[];
        if (is_array($tipoTrans)) { 
            $tipoTransp = implode(", ", $tipoTrans); 
        } else { 
            $tipoTransp = $tipoTrans; 
        }
        $naviera = isset($_POST['navieras'])?$_POST['navieras']:[];
        if (is_array($naviera)) { 
            $navierasp = implode(", ", $naviera); 
        } else { 
            $navierasp = $tipoContenedor; 
        }
        $obs = isset($_POST['obs'])?$_POST['obs']:'';
        $vendedor = isset($_SESSION['usuario'])?$_SESSION['usuario']:'';
        if (isset($ro) ){
            //echo 'no esta nulo'.$ro;
            $consulta = $con->prepare("INSERT INTO embarques (fecha_registro, ro, shipper, mbl, proveedor, consignatario, ncontenedor, tcontenedor, ccontenedor, mercancia, 
        porigen, pllegada, fsalida, fllegada, invoice, venta, comprat, ventas, compras, ventat, 
        totalp, tcontable, tipot, naviera, obs, vendedor)
        VALUES( '$fecha_registro','$ro','$shipper','$mbl','$proveedor','$consignatario','$numeroContenedor','$tipoContenedorStr',$cantidadContenedor,'$mercancia',
        '$pOrigenes','$pLlegadas','$fSalida','$fLlegada','$invoice',$venta,$compraT,$ventaS,$compraS,$ventaT,
        $totalP,$Tcontable,'$tipoTransp','$navierasp','$obs','$vendedor')");
        
        try{
        //echo $consulta->queryString;
        
        $consulta->execute();
        $cuenta = $consulta -> rowCount(); 
        //echo "  **datos ".$cuenta;
        if ($cuenta == 1){
            $climen='Se Registro la Venta '.$ro.' ... Exitosamente!';
            //echo " se insertaron los datos";
            //header("Location: reg_venta.php");
        }else{
            $climen=' ';
        }

        }
            catch(PDOException $exp)
        {
            //$climen = $exp;
            //var_dump($exp);
         }
       // }
        }//else{echo 'Si esta nulo'.$ro;}
        
    }else{
        echo "datos nulos";
        // var_dump($_POST);
    }
?>