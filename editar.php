<?php
session_start();
require_once "Conexion.php";

if (isset($_SESSION['usuario'])) {
     

$usuario = $_SESSION['usuario'];
$con = CConexion::ConexionDB();
//var_dump($_POST);
//var_dump($_GET);
$fecha_registro = date("Y-m-d H:i:s");
$nro = $_POST['nro'];
//echo "usuario ".$usuario;
//echo "nro  ".$nro;
$vend = $usuario; // Usar el usuario autenticado
$ro = $_POST['ro'];
$servicio = $_POST['servicio'];
$tipoTrans = $_POST['tipot'] ?? '';
$naviera = $_POST['naviera'] ?? ''; 
$proveedor = $_POST['proveedor'];
$consignatario = $_POST['consignatario'];
$mbl = $_POST['mbl'];
$numeroContenedor = $_POST['ncontenedor'];
$tipoContenedor = $_POST['tcontenedor'] ?? '';
$cantidadContenedor = $_POST['ccontenedor'];
$mercancia = $_POST['mercancia'];
$pOrigen = $_POST['porigen'];
$fSalida = $_POST['fsalida'];
$pLlegada = $_POST['pllegada'];
$fLlegada = $_POST['fllegada'];
$venta = $_POST['venta'];
$ventaT = $_POST['ventat'];
$compraT = $_POST['comprat'];
$totalP = $_POST['totalp'];
$Tcontable = $_POST['tcontable'];
$nro = $_POST['nro'];
$obs = $_POST['obs'];

try {
    if ($nro > 0) {
        # code...
    
        $consulta = $con->prepare("UPDATE embarques SET 
        ro=:ro,
        servicio=:servicio,
        tipot=:tipoTrans,
        naviera=:naviera,
        proveedor=:proveedor,
        consignatario=:consignatario,
        mbl=:mbl,
        ncontenedor=:numeroContenedor,
        tcontenedor=:tipoContenedor,
        ccontenedor=:cantidadContenedor,
        mercancia=:mercancia,
        porigen=:pOrigen,
        fsalida=:fSalida,
        pllegada=:pLlegada,
        fllegada=:fLlegada,
        venta=:venta,
        ventat=:ventaT,
        comprat=:compraT,
        totalp=:totalP,
        tcontable=:Tcontable,
        obs=:obs
        WHERE nro = :nro AND vendedor = :vend");
        $consulta->bindParam(':ro', $ro);
        $consulta->bindParam(':servicio', $servicio);
        $consulta->bindParam(':tipoTrans', $tipoTrans);
        $consulta->bindParam(':naviera', $naviera);
        $consulta->bindParam(':mbl', $mbl);
        $consulta->bindParam(':proveedor', $proveedor);
        $consulta->bindParam(':consignatario', $consignatario);
        $consulta->bindParam(':numeroContenedor', $numeroContenedor);
        $consulta->bindParam(':tipoContenedor', $tipoContenedor);
        $consulta->bindParam(':cantidadContenedor', $cantidadContenedor);
        $consulta->bindParam(':mercancia', $mercancia);
        $consulta->bindParam(':pOrigen', $pOrigen);
        $consulta->bindParam(':fSalida', $fSalida);
        $consulta->bindParam(':pLlegada', $pLlegada);
        $consulta->bindParam(':fLlegada', $fLlegada);
        $consulta->bindParam(':venta', $venta);
        $consulta->bindParam(':ventaT', $ventaT);
        $consulta->bindParam(':compraT', $compraT);
        $consulta->bindParam(':totalP', $totalP);
        $consulta->bindParam(':Tcontable', $Tcontable);
        $consulta->bindParam(':obs', $obs);
        $consulta->bindParam(':nro', $nro);
        $consulta->bindParam(':vend', $vend);

        if ($consulta->execute()) {
            $nro;
            //echo "Actualización exitosa";
        } else {
            echo "Error: " . print_r($consulta->errorInfo(), true);
        }
    }else{
        echo "no hay datos para modificar";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
}else{
    echo "Usuario no autenticado.";
exit;
}


?>