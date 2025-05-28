<?php
session_start();
include_once("Conexion.php");
include_once("cabecera.php");
//include_once("ReporteGral_cod.php");
$con=CConexion::ConexionDB();

if (!isset($_SESSION['usuario'])) {
    echo "Usuario no autenticado.";
    exit;
}
//echo $_SESSION['usuario'];
$usuario = $_SESSION['usuario'];
//pasamos un nuevo parametro para los querys
//$mes = '202502';

$sqls=" select c.sucursal from usuarios a, trabajador b, cat_sucursal c
        where a.per_id=b.id and a.us_email='$usuario' and b.sucursal=c.id";
$consulta=$con->query($sqls);
$consulta->execute();
$agencia=$consulta->fetch(PDO::FETCH_ASSOC);

$sqlMeses="	select distinct to_char(a.fllegada,'yyyymm') as mes
	from embarqueventas a, usuarios b, trabajador c
	where a.vendedor=b.us_email and b.per_id=c.id
    and a.id_suc=(select sucursal from usuarios a, trabajador b
    where a.per_id=b.id and a.us_email='$usuario')
	order by 1";
$consultaMeses=$con->query($sqlMeses);
$consultaMeses->execute();
$mesesDisponibles = $consultaMeses->fetchAll(PDO::FETCH_ASSOC);

$usuarios = array("IVAlan", "QLuis","IVKriss","MMLaura");
/*if (in_array($usuario, $usuarios)) {
 //echo "en el if";
    
    $sqli=" SELECT 
        DISTINCT  CAST(CONCAT(CAST(EXTRACT(year FROM fllegada) AS INT), '', LPAD(CAST(EXTRACT(MONTH FROM fllegada) AS INT)::text, 2, '0')) AS INT) AS gestion 
        FROM embarques  
        ORDER BY 1 DESC";
    $tipos=$con->query($sqli);
    $tipo=$tipos->fetchAll();
    //print_r($tContenedor);
}else{
        echo "Usuario no Autorizado";
        header('Location: ini.php');
 }*/

?>
<head>    
    <link rel="stylesheet" href="estiloc.css">
</head>

<body>
    <!--la lista desplegable-->
    <!--<h3>Seleccione un periodo:</h3>-->
    <label for="mesSeleccionado">Seleccione un periodo de ventas:</label>
    <select id="mesSeleccionado" class="form-select">
        <option value=""> </option>
        <?php foreach ($mesesDisponibles as $mes) { ?>
            <option value="<?php echo $mes['mes']; ?>"><?php echo $mes['mes']; ?></option>
        <?php } ?>
    </select>
    
 <div id="graficosContainer" style="display: none;">
    <div class="grid-layout">
        <div class="card border-danger">
            <div class="card-header border-danger bg-danger text-white">
                Estadísticas por Vendedor <?php echo $agencia['sucursal']; ?>
            </div>
            <div class="card-body">
                <canvas id="pagosChart"></canvas>
            </div>
        </div>

        <div class="card border-danger">
            <div class="card-header border-danger bg-danger text-white">
                Estadísticas por tipo de transporte <?php echo $agencia['sucursal']; ?>
            </div>
            <div class="card-body">
                <canvas id="cobrosChart"></canvas>
            </div>
        </div>

        <div class="card border-danger full-width">
            <div class="card-header border-danger bg-danger text-white">
                Estadísticas de ventas Sucursal <?php echo $agencia['sucursal']; ?>
            </div>
            <div class="card-body">
                <canvas id="ventasChart"></canvas>
            </div>
        </div>
    </div>
</div>

             
    <!--modifica tamaño del canvas-->
    <!--<canvas id="ventasChart" style="width: 500px; height: 300px;"></canvas>-->
    
    
    
    <script>
        
        const usuario = "<?php echo $_SESSION['usuario']; ?>"; // Mantener usuario desde PHP
           
        document.getElementById("mesSeleccionado").addEventListener("change", function() {
        const mes = this.value; // Capturar el valor del mes seleccionado
            console.log("Usuario:", usuario);
            console.log("Mes seleccionado:", mes);
            // Enviar `usuario` y `mes` a `scripts.js`
            procesarDatos(usuario, mes);
        });
    </script>
<span id="usuario" style="display: none;"><?php echo $_SESSION['usuario']; ?></span>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="scripts.js"></script> <!-- Mueve la lógica de gráficos a un archivo separado -->
        <script>
            // Cuando la página se cargue, desplazar automáticamente al inicio
            window.onload = function() {
            window.scrollTo(0, 0);
            };
        </script>             
</body>
</html>
