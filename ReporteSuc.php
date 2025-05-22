<?php
session_start();
include_once("Conexion.php");
include_once("cabecera.php");
include_once("ReporteGral_cod.php");
$con=CConexion::ConexionDB();

if (!isset($_SESSION['usuario'])) {
    echo "Usuario no autenticado.";
    exit;
}
//echo $_SESSION['usuario'];
$usuario = $_SESSION['usuario'];
//$usuarios = array("IVAlan", "QLuis","IVKriss","MMLaura");
//if (in_array($usuario, $usuarios)) {
 //echo "en el if";
    
    $sqli=" SELECT 
            DISTINCT  CAST(CONCAT(CAST(EXTRACT(year FROM fllegada) AS INT), '', LPAD(CAST(EXTRACT(MONTH FROM fllegada) AS INT)::text, 2, '0')) AS INT) AS gestion 
            FROM embarqueventas  
            ORDER BY 1 DESC";
    $tipos=$con->query($sqli);
    $tipo=$tipos->fetchAll();
    //print_r($tContenedor);
/*}else{
        echo "Usuario no Autorizado";
        header('Location: ini.php');
 }*/

?>
   
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <div class="card border-danger">
        <div class="card-header border-danger bg-danger text-white">Lista General de Embarques por Gestión</div>
        <div class="card-body ">
        
        <div class="col-md-4">
            <form action="" method="post">    
            <label for="inputState" class="form-label form-control-sm text-danger">GESTIÓN:</label>
                <select id="tipos" name="tipo" class="form-select form-select-sm text-uppercase"  >
                    <option selected> </option>
                    <?php foreach ($tipo as $tContenedores) { ?>	
                        <option  style="text-transform:uppercase" <?php
                                if (!empty($tipos)) {
                                        if (in_array($tContenedores['gestion'],$tipo)) {
                                        echo 'selected';
                                        }
                                }
                                ?>
                        value="<?php echo $tContenedores['gestion']; ?>" ><?php echo $tContenedores['gestion']; ?>
                        </option>  
                    <?php } ?>
                </select>
                </form>
            </div>
        
      <BR></BR>

       <!-- TABLA -->
       <table id="registros" class="table table-hover table-danger">
        <thead>
            <tr>
            <th scope="row"> </th>
            <td colspan="1" style="text-align: center; font-weight: bold;" >.</td>
            <td colspan="3" style="text-align: center; font-weight: bold;" >VENTAS TOTALES</td>
            <td colspan="4" style="text-align: center; font-weight: bold;" >TIPO TRANSPORTES</td>
            <td colspan="4" style="text-align: center; font-weight: bold;" >CANTIDAD CONTENEDORES</td>
            </tr>
            <tr>
                <th style="text-align: center;">VENDEDOR</th>
                <th style="text-align: center;">NRO VENTAS</th>
                <th style="text-align: center;">MONTO VENTA</th>
                <th style="text-align: center;">CANTIDAD CONTENEDORES</th>
                <th style="text-align: center;">MARITIMO</th>
                <th style="text-align: center;">AEREO</th>
                <th style="text-align: center;">TERRESTRE</th>
                <th style="text-align: center;">OTROS</th>
                <th style="text-align: center;">20 DRY</th>
                <th style="text-align: center;">40 DRY</th>
                <th style="text-align: center;">40 HC</th>
                <th style="text-align: center;">OTROS</th>
            </tr>
        </thead>
        <tbody class="table" id="tabla">
        </tbody>
       </table>
<!--script>
        function datos(ges) {
            console.log(ges);
            $.ajax({
                url: 'ReporteGral_cod.php',
                type: 'POST',
                data: { ges: ges },
                success: function(data) {
                    $('#tabla').html(data);
                }
            });
        }
</script--> 
<script>
        $(document).ready(function() {
            // Cargar categorías al cargar la página
           /* $.ajax({
                url: 'ReporteGral_cod.php',
                method: 'GET',
                success: function(data) {
                    $('#tipos').append(data);
                }
            });*/
            console.log("en la funcion 00 ");
            // Cargar productos al seleccionar una categoría
            $('#tipos').change(function() {
                console.log("en la funcion");
                var tiposId = $(this).val();
                console.log(tiposId);
                $.ajax({
                    url: 'ReporteSuc_cod.php',
                    method: 'GET',
                    data: { ges: tiposId },
                    success: function(data) {
                        $('#registros tbody').html(data);
                    }
                });
            });
        });
    </script>

<?php include_once("pie.php"); ?>
        