<?php  
  session_start();
  require_once('config.php');
  include_once("Conexion.php");
  //echo $_SESSION['usuario'];
  $usuario = $_SESSION['usuario'];
  //echo "en seguiDet ccc   ";
  //var_dump($_GET);
  //var_dump($_POST);
  if (isset($_GET['ges'])) {
   // var_dump("entro al ifff ");
      
      $dato = $_GET['ges']; // Normalizar el dato
      //var_dump($nro );
      $con = CConexion::ConexionDB();
      $consulta = " SELECT 
                    a.nro,a.proveedor, a.consignatario, a.porigen, a.ro, a.tccontenedor,
                    a.fsalida,  a.fllegada,a.servicio,a.mbl,a.ttransporte,a.naviera,
                    a.ventat,a.obs, a.pllegada,
                    (SELECT STRING_AGG(ncontenedor, ', ') 
                    FROM embarqueventas_det b 
                    WHERE b.idnro=a.nro) AS ncontenedor,
                    (SELECT STRING_AGG(tcontenedor, ', ') 
                    FROM embarqueventas_det b 
                    WHERE b.idnro=a.nro) AS tcontenedor
                    FROM embarqueventas a
                    WHERE a.consignatario = '$dato' and a.vendedor = '$usuario'
                    ORDER BY a.fllegada ASC ";
  //var_dump($resultado);
      $resultado = $con->prepare($consulta);
      //$resultado->bindParam(':nro', $nro, PDO::PARAM_INT);
    
      try {
          $resultado->execute();
          echo "<table id='casos' class='table table-danger'>
                <thead>
                    <tr class='table-danger'>
                      <th scope='row' id='titulo' colspan='17' style='text-align: center; font-weight: bold; font-size: 14px;'>SEGUIMIENTO DE CARGA CLIENTE: ".$dato."</th>
                    </tr>
                    <tr class='table-danger' style='text-align: center;'>
                        <th>RO</th>
                        <th>CLIENTE</th>
                        <th>PROVEEDOR</th>
                        <th>PUERTO SALIDA</th>
                        <th>ETD</th>
                        <th>PUERTO LLEGADA</th>
                        <th>ETA</th>
                        <th>MBL</th>
                        <th>OHBL</th>
                        <th>NUMERO CONTENEDOR</th>
                        <th>TIPO CONTENEDOR</th>
                        <th>SEGURO</th>
                        <th>CANTIDAD CONTENEDOR</th>
                        <th>FLETE MARITIMO</th>
                        <th>NAVIERA</th>
                        <th>VENTA</th>
                        <th>OBSERVACIONES</th>
                    </tr>
                </thead>
                <tbody class='table' id='tablaC'>";
                while($row = $resultado ->fetch(PDO::FETCH_ASSOC)){
                        echo "<tr style='text-align: center;'>
                            <th>".$row['ro']."</th>
                            <th>".$row['consignatario']."</th>
                            <th>".$row['proveedor']."</th>
                            <th>".$row['porigen']."</th>
                            <th>".$row['fsalida']."</th>
                            <th>".$row['pllegada']."</th>
                            <th>".$row['fllegada']."</th>
                            <th>".$row['mbl']."</th>
                            <th>".$row['mbl']."</th>
                            <th>".$row['ncontenedor']."</th>
                            <th>".$row['tcontenedor']."</th>
                            <th>".$row['servicio']."</th>
                            <th>".$row['tccontenedor']."</th>
                            <th>".$row['ttransporte']."</th>
                            <th>".$row['naviera']."</th>
                            <th>".$row['ventat']."</th>
                            <th>".$row['obs']."</th>
                            </tr>";
                }
            
                echo "</tbody>
            </table>";  

         /* if (!empty($segEmb)) {
              echo json_encode($segEmb);
          } else {
              echo json_encode(["error" => "No se encontraron datos"]);
          }*/
      } catch (PDOException $e) {
          echo json_encode(["error" => $e->getMessage()]);
     }
  }
?>
