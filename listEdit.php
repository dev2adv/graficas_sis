<?php
require_once('config.php');
include_once("Conexion.php");

//header('Content-Type: application/json');

if (isset($_POST['nro'])) {
    $nro = $_POST['nro'];
    $con = CConexion::ConexionDB();

    // Primera consulta
    $consulta = "SELECT ro, servicio, ttransporte, naviera, proveedor, consignatario, mbl, tccontenedor, porigen, fsalida, pllegada, fllegada, ventat, comprat, totalp, tcontable, nro, obs
                 FROM embarqueventas WHERE nro = :nro";
    $resultado = $con->prepare($consulta);
    $resultado->bindParam(':nro', $nro, PDO::PARAM_INT);
    $resultado->execute();
    $embarques = $resultado->fetchAll(PDO::FETCH_ASSOC);

    // Segunda consulta
    $consultad = "SELECT idemb, idnro, ncontenedor, tcontenedor, mercancia, ccontenedor, venta, ventat, comprat, totalp, fecha_registro, vendedor, id_suc
                  FROM embarqueventas_det WHERE idnro = :nro";
    $resultadod = $con->prepare($consultad);
    $resultadod->bindParam(':nro', $nro, PDO::PARAM_INT);
    $resultadod->execute();
    $embarquesdet = $resultadod->fetchAll(PDO::FETCH_ASSOC);

    // Verifica si JSON se generó correctamente
    $jsonData = json_encode(['embarques' => $embarques, 'embarquesdet' => $embarquesdet]);

    if ($jsonData === false) {
        echo json_encode(["error" => "Error al generar JSON"]);
    } else {
        echo $jsonData;
    }
    // exit();
}

?>
