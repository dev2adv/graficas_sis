<?php
    //require_once('./config.php');
    include_once("Conexion.php");
    include('login.php');
    var_dump($_POST);
    var_dump($_GET);
    //if (isset($_GET['ges'])) {

    $ges=1;//$_GET['id'];
    $usuario = $_SESSION['usuario'];
    //var_dump($ges);
    
    $con=CConexion::ConexionDB();

    $resultados= [];
    //$row=[];
    $html="";
    $sql = "select A.TRABAJADOR
    from trabajador a, usuarios b
    where a.id=b.per_id and a.estado='A' and a.cargo='VENDEDOR' and a.sucursal='".$ges."'
    ORDER BY 1 ASC";
var_dump($sql);
$stmt = $con->prepare($sql);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
var_dump($resultados);
                   $html .=' <thead>
                                <tr>
                                    <th >Vendedor</th>
                                </tr>
                             </thead>';
    foreach ($resultados as $rows => $reg) {
                $html .= ' <tbody>
                            <tr>
                            <th scope="row">'.$reg['trabajador'].'</th>
                            </tr>
                        </tbody>';                
         //   }
               
            
        }
        echo $html;
  //  }
    


       
            
            $num=0;

        /*    echo '<thead>
                    <tr>
                    <th colspan="2"  scope="col">Sucursal: '.$suc['sucursal'].' </th>
                    </tr>
                    <tr>
                    <th scope="col">Nro. </th>
                    <th scope="col">Nombre Vendedor </th>
                    </tr>
                  </thead>';
*/
        //    foreach ($resultados as $row => $value) {
               // $num = $num + 1;

    
?>