<?php
    include_once("Conexion.php");
    $nro = $_POST['inc'];

    $con=CConexion::ConexionDB();
    $consulta="DELETE FROM embarqueventas WHERE nro = $nro";
    $resultado=$con->prepare($consulta);

    $consultad="DELETE FROM embarqueventas_det WHERE idnro = $nro";
    $resultadod=$con->prepare($consultad);

    try{
        $resultado->execute();
        $resultadod->execute();
    }
    catch(PDOException $exp)
    {
        echo $exp;
        //var_dump($consulta);
    }
?>
