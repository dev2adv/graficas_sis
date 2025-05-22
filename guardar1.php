<?php
    require_once"Conexion.php";
    include('login.php');
    //include('cabecera.php');
    $con=CConexion::ConexionDB();
   
    //var_dump("guardar2.php");
    var_dump('inicio guardar1');
    $data = json_decode(file_get_contents("php://input"), true);
// if (json_last_error() !== JSON_ERROR_NONE) {
//     die("Error en JSON: " . json_last_error_msg());
// }
    var_dump("salio del jason", $data);
    //exit();

   // if (isset($_POST)) {
    date_default_timezone_set('America/La_Paz'); // Configurar la zona horaria correcta
        
        $fecha_registro = date("Y-m-d H:i:s");
        //foreach($data['formulario'] as $rowf){
            
            // $impnom=isset($rowf['impnom'])?$rowf['impnom']:'';
           
        //var_dump("prueba", $rowf);
        $ovendedor=$data['formulario']['vendedores[]'];
        if (is_array($ovendedor)) { 
            $xvendedor = implode(", ", $ovendedor); 
        } else { 
            $xvendedor = $ovendedor; 
        }
        $vsucursal=$data['formulario']['sucursales[]'];
        if (is_array($vsucursal)) { 
            $xsucursal = implode(", ", $vsucursal); 
        } else { 
            $xsucursal = $vsucursal; 
        }

        $ro  =$data['formulario']['ro'];
        var_dump($ro);
        $Xservicio=$data['formulario']['vservicio[]'];
        if (is_array($Xservicio)) { 
            $tservicio = implode(", ", $Xservicio); 
        } else { 
            $tservicio = $Xservicio; 
        }
        $tipoTrans = $data['formulario']['transporte[]'];
        if (is_array($tipoTrans)) { 
            $tipoTransp = implode(", ", $tipoTrans); 
        } else { 
            $tipoTransp = $tipoTrans; 
        }
        $naviera =  $data['formulario']['navieras[]'];
        if (is_array($naviera)) { 
            $navierasp = implode(", ", $naviera); 
        } else { 
            $navierasp = $naviera; 
        }
        
        $proveedor =  $data['formulario']['proveedor'];
        $consignatario =  $data['formulario']['consig'];
        
        $mbl = $data['formulario']['mbl'];
        //$tccontenedor =isset( $rowf['tccontenedor'])?$rowf['tccontenedor']:0;
        $pOrigen = $data['formulario']['origen[]'];
        /*if (is_array($pOrigen)) { 
            $pOrigenes = implode(", ", $pOrigen); 
        } else { 
            $pOrigenes = $pOrigen; 
        }*/
        $pLlegada = $data['formulario']['llegada[]'];
        /*if (is_array($pLlegada)) { 
            $pLlegadas = implode(", ", $pLlegada); 
        } else { 
            $pLlegadas = $pLlegada; 
        }*/
        $fSalida = $data['formulario']['salida'];

        $fllegada = $data['formulario']['Fllegada'];
        var_dump("fleegada", $data['formulario']['Fllegada']);

        $tccontenedor =$data['formulario']['tcontenedoresT'];
        $compraT = $data['formulario']['compraT'];
        $ventaT = $data['formulario']['tventaT'];
        $totalP = $data['formulario']['profitT'];
        $Tcontable = $data['formulario']['tcontable'];
        
        
        $obs = $data['formulario']['obs'];
        $vendedor = isset($_SESSION['usuario'])?$_SESSION['usuario']:'';
         

       // }
        
       // $data = json_decode(file_get_contents("php://input"), true);
        //var_dump($data);
        //exit();
              
        $cuenta = 0;
        $cuentad = 0;

        $sql=" select b.sucursal
            FROM usuarios a, trabajador b, cat_sucursal c, roles d
            where a.per_id=b.id and us_email= :user 
            and b.sucursal=c.id 
            and a.rol_id=d.rol_id ";
        $consultas=$con->prepare($sql);
        $consultas->bindParam(':user',$vendedor);
        $consultas->execute();
        $usnombre=$consultas->fetch(PDO::FETCH_ASSOC);
        $sucursal = $usnombre['sucursal'];

        //if (isset($ro) && !empty($data['datosTabla'])){
            // Obtener el próximo valor de la secuencia
            $stmt = $con->query("select nextval('seq_embvent'::regclass)");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $nro = $row['nextval'];
            var_dump("numero file ");
            var_dump($nro);
            $consulta = $con->prepare("INSERT INTO public.embarqueventas (
                nro, ro, servicio, naviera, proveedor, consignatario, mbl, porigen, fsalida, pllegada, 
                fllegada, tccontenedor, ventat, comprat, totalp, tcontable, obs, fecha_registro, vendedor, id_suc, ttransporte)
                VALUES (:nro, :ro, :servicio, :naviera, :proveedor, :consignatario, :mbl, :porigen, :fsalida, :pllegada, 
                :fllegada, :tccontenedor, :ventat, :comprat, :totalp, :tcontable, :obs, :fecha_registro, :vendedor, :id_suc, :ttransporte)");
            
            $consulta->bindParam(':nro', $nro, PDO::PARAM_INT);
            $consulta->bindParam(':ro', $ro, PDO::PARAM_STR);
            $consulta->bindParam(':servicio', $tservicio, PDO::PARAM_STR);
            $consulta->bindParam(':naviera', $navierasp, PDO::PARAM_STR);
            $consulta->bindParam(':proveedor', $proveedor, PDO::PARAM_STR);
            $consulta->bindParam(':consignatario', $consignatario, PDO::PARAM_STR);
            $consulta->bindParam(':mbl', $mbl, PDO::PARAM_STR);
            $consulta->bindParam(':porigen', $pOrigen, PDO::PARAM_STR);
            $consulta->bindParam(':fsalida', $fSalida, $fSalida ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $consulta->bindParam(':pllegada', $pLlegada, PDO::PARAM_STR);
            $consulta->bindParam(':fllegada', $fllegada, $fllegada ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $consulta->bindParam(':tccontenedor', $tccontenedor, PDO::PARAM_INT);
            $consulta->bindParam(':ventat', $ventaT, PDO::PARAM_STR);
            $consulta->bindParam(':comprat', $compraT, PDO::PARAM_STR);
            $consulta->bindParam(':totalp', $totalP, PDO::PARAM_STR);
            $consulta->bindParam(':tcontable', $Tcontable, PDO::PARAM_STR);
            $consulta->bindParam(':obs', $obs, PDO::PARAM_STR);
            $consulta->bindParam(':fecha_registro', $fecha_registro, PDO::PARAM_STR);
            $consulta->bindParam(':vendedor', $xvendedor, PDO::PARAM_STR);
            $consulta->bindParam(':id_suc', $xsucursal, PDO::PARAM_INT);
            $consulta->bindParam(':ttransporte', $tipoTransp, PDO::PARAM_STR);
            
                       
            var_dump($consulta);
            $consulta->execute();
            
            $cuenta = $consulta -> rowCount(); 
            echo "  **datos ".$cuenta;
            var_dump("datos de la tabla ");
            var_dump($data['tabla'] );
            
                foreach ($data['tabla'] as $fila) {
                    var_dump('entra al foreach para insertar detalle');
                    $xcontenedor = !empty($fila['contenedor']) ? $fila['contenedor'] : 'Sin contenedor';
                    $xtipo = !empty($fila['tipo']) ? $fila['tipo'] : 'Sin tipo';
                    $xproducto = !empty($fila['producto']) ? $fila['producto'] : 'Sin producto';
                    $xcantidad = !empty($fila['cantidad']) ? $fila['cantidad'] : 0;
                    $xventaUnitaria = !empty($fila['ventaUnitaria']) ? $fila['ventaUnitaria'] : 0;
                    $xtotalVenta = !empty($fila['totalVenta']) ? $fila['totalVenta'] : 0;
                    $xcompra = !empty($fila['compra']) ? $fila['compra'] : 0;
                    $xprofit = !empty($fila['profit']) ? $fila['profit'] : 0;
                    $stmtd = $con->query("select nextval('seq_embventd'::regclass)");
                    $rowd = $stmtd->fetch(PDO::FETCH_ASSOC);
                    $nrod = $rowd['nextval'];
                    var_dump($nro);

                    $consultad = $con->prepare("INSERT INTO public.embarqueventas_det (
                        idemb, idnro, ncontenedor, tcontenedor, mercancia, ccontenedor, venta, ventat, comprat, totalp, fecha_registro, vendedor, id_suc)
                        VALUES (:idemb, :idnro, :ncontenedor, :tcontenedor, :mercancia, :ccontenedor, :venta, :ventat, :comprat, :totalp, :fecha_registro, :vendedor, :id_suc)");
                    
                    $consultad->bindParam(':idemb', $nrod, PDO::PARAM_INT);
                    $consultad->bindParam(':idnro', $nro, PDO::PARAM_INT);
                    $consultad->bindParam(':ncontenedor', $xcontenedor, PDO::PARAM_STR);
                    $consultad->bindParam(':tcontenedor', $xtipo, PDO::PARAM_STR);
                    $consultad->bindParam(':mercancia', $xproducto, PDO::PARAM_STR);
                    $consultad->bindParam(':ccontenedor', $xcantidad, PDO::PARAM_INT);
                    $consultad->bindParam(':venta', $xventaUnitaria, PDO::PARAM_STR);
                    $consultad->bindParam(':ventat', $xtotalVenta, PDO::PARAM_STR);
                    $consultad->bindParam(':comprat', $xcompra, PDO::PARAM_STR);
                    $consultad->bindParam(':totalp', $xprofit, PDO::PARAM_STR);
                    $consultad->bindParam(':fecha_registro', $fecha_registro, PDO::PARAM_STR);
                    $consultad->bindParam(':vendedor', $vendedor, PDO::PARAM_STR);
                    $consultad->bindParam(':id_suc', $sucursal, PDO::PARAM_INT);
                    
                
                    var_dump($consultad);
                    
                    $consultad->execute();
                    
                    $cuentad = $consultad -> rowCount(); 
                    echo "  **datos det ".$cuentad;
                }
           
                
                if ($cuenta == 1 && $cuentad >= 1){
                    $climen='Se Registro la Venta total '.$ro.' ... Exitosamente!';
                    echo " se insertaron los datos";
                    //header("Location: reg_venta.php");
                }else{
                    $climen=' Error en el Registro... ';
                }
        
      /* } catch(PDOException $exp) {
            //$climen = $exp;
            $climen = $exp;
         }*/
        
        /*}else{
            $climen = 'Inserte un nuevo registro '.$ro;
        }*/
        
   /* }else{
        $climen = "datos nulos";
        // var_dump($_POST);
    }*/
?>
