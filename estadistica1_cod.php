<?php
    //require_once('./config.php');
    include_once("Conexion.php");
    include('login.php');
    //var_dump($_POST);
    //var_dump($_GET);
    //if (isset($_GET['ges'])) {

    //$ges=$_GET['id'];
    $usuario = $_SESSION['usuario'];
    //var_dump($ges);
    
    $con=CConexion::ConexionDB();

    $resultados= [];
    //$row=[];
    $html="";
    $sqls =" SELECT distinct d.sucursal,d.id
            FROM embarqueventas a
            INNER JOIN usuarios b ON a.vendedor = b.us_email
            INNER JOIN trabajador c ON b.per_id = c.id
            INNER JOIN cat_sucursal d ON c.sucursal = d.id
            ORDER BY 1 ASC";
    $stmts = $con->prepare($sqls);
    $stmts->execute();
    $results = $stmts->fetchAll(PDO::FETCH_ASSOC);
                  /* $html .=' <thead>
                                <tr>
                                <th >Nro</th>
                                <th >Sucursal</th>
                             </tr>
                        </thead>';*/
    foreach ($results as $rows => $suc) {
                echo  ' <tbody>
                            <tr>
                            <th scope="row">'.$suc['id'].'</th>
                            <td >'.$suc['sucursal'].'</td>
                            </tr>
                        </tbody>';                
         //   }
               
            
        }
        //echo $html;
  //  }
    



    
?>