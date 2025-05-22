<?php
    //session_start();
    //require_once('./config.php');
    include_once("Conexion.php");
    include('login.php');

    if (isset($_POST['mes'])) {

        $mes=$_POST['mes'];
    }
    $usuario = $_SESSION['usuario'];

    $con=CConexion::ConexionDB();
    //print_r($_POST);
    $cliente = "";
   $accion=isset($_POST['accion'])?$_POST['accion']:'';
   $usuario=isset($_POST['usuario'])?$_POST['usuario']:'';
   $contraseña=isset($_POST['password'])?$_POST['password']:'';
   if(isset($_POST['consig']))
   {
       $cliente = $_POST['consig'];
    }
   
   date_default_timezone_set('America/La_Paz');

   
   $fechactual = date('d-m-Y h:i:s');

   $sqlcli=" SELECT A.IMPORTADORA as imp,B.TIPO as tdoc ,A.NRODOC as ndoc FROM CLIENTES A, CAT_TIPO_DOC B
   WHERE A.IMPORTADORA LIKE '$cliente' AND A.DOCT_ID=B.ID
   ORDER BY IMPORTADORA ASC ";
   //$listaClientes->bindParam(':cliente');
   $listaClientes=$con->prepare($sqlcli);
   //$clienteb=
   $listaClientes->execute();

   /*$html = "";
   
   while($row = $listaClientes -> fetch(PDO::FETCH_ASSOC)){
        $html .= "<li>".$row["imp"]."-".$row["tdoc"]."-".$row["ndoc"]."</li>";
   }

   echo json_encode($html, JSON_UNESCAPED_UNICODE);*/
   
   $sqlf=" SELECT (CURRENT_date + INTERVAL '7 day')::date AS tomorrow_date ";
   $result=$con->query($sqlf);
   $fechavenc=$result->fetch(PDO::FETCH_ASSOC);
   //print_r($fechavenc);
   
   $sqlven=" SELECT a.us_email, UPPER( b.trabajador) AS TRABAJADOR
   FROM usuarios a, trabajador b, cat_sucursal c, roles d
   where a.per_id=b.id and a.us_email <> '$usuario' and b.AREA='COMERCIAL'
   and b.sucursal=c.id AND B.ESTADO='I'
   and a.rol_id=d.rol_id ";
   $listven=$con->query($sqlven);
   $vendedores=$listven->fetchAll();
   //print_r($vendedores);

   $sqlser=" SELECT * FROM public.cat_servicio where estado='A' ";
   $listaserv=$con->query($sqlser);
   $vservicio=$listaserv->fetchAll();
  // print_r($listaserv);
  

   $sql=" SELECT *	FROM public.cat_agente_prov ";
   $listaAgente=$con->query($sql);
   $agente=$listaAgente->fetchAll();
   //  print_r($agente);

   $sqli=" select * from cat_tipo_contenedor ";
   $listaTContenedor=$con->query($sqli);
   $tipo=$listaTContenedor->fetchAll();
   //print_r($tContenedor);
   
   $sqls=" SELECT *	FROM public.cat_sucursal ";
   $listasuc=$con->query($sqls);
   $sucursales=$listasuc->fetchAll();
   //print_r($sucursales);

   $sqlt=" SELECT * FROM public.cat_transporte ";
   $listatrans=$con->query($sqlt);
   $transporte=$listatrans->fetchAll();
   //print_r($transporte);
  
   $sqle=" SELECT * FROM public.cat_embarque ";
   $listembarque=$con->query($sqle);
   $embarque=$listembarque->fetchAll();
   //print_r($embarque);

   $sqlpor=" SELECT * FROM public.cat_puerto_origen WHERE estado = 'A' ORDER BY PUERTO DESC ";
   $listapor=$con->query($sqlpor);
   $origen=$listapor->fetchAll();
   //print_r($transporte);
  
   $sqlpod=" SELECT * FROM public.cat_puerto_llegada ";
   $listapod=$con->query($sqlpod);
   $llegada=$listapod->fetchAll();
   //print_r($embarque);

   $sqlnav=" SELECT *	FROM cat_empresas_tra ";
   $listnav=$con->query($sqlnav);
   $navieras=$listnav->fetchAll();
   //print_r($embarque);
   
   

     
?>