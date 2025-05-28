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

$sqls=" select c.sucursal from usuarios a, trabajador b, cat_sucursal c
        where a.per_id=b.id and a.us_email='$usuario' and b.sucursal=c.id";
$consulta=$con->query($sqls);
$consulta->execute();
$agencia=$consulta->fetch(PDO::FETCH_ASSOC);



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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<head>
    <link rel="stylesheet" href="estiloc.css">
</head>

<body>
    <div class="card border-danger">
        <div class="card-header border-danger bg-danger text-white">Estadísticas de Ventas <?php echo $agencia['sucursal']; ?> </div>
        <div class="card-body " style="justify-content: center;">
            <canvas id="ventasChart" ></canvas>
        </div>
        </div>
    </div>
    <!--modifica tamaño del canvas-->
    <!--<canvas id="ventasChart" style="width: 500px; height: 300px;"></canvas>-->
    <script>
        console.log("inicio de la grafica");
        fetch('estadisticaSuc_cod.php?usuario=<?php echo $usuario; ?>')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(row => row.periodo);
                console.log(labels);
                const suc = data.map(row => row.casos);
                console.log(suc);
                const cantidades = data.map(row => row.casos);
                console.log(cantidades);
                const ctx = document.getElementById('ventasChart').getContext('2d');
                console.log(ctx);
                
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Ventas de la sucursal',
                            data: cantidades,
                            borderColor: 'rgb(2, 63, 63)',
                            backgroundColor: 'rgba(146, 16, 31, 0.6)',
                            borderWidth: 2,
                            barThickness: 80, // Ajusta el grosor de las barras en píxeles
                            barPercentage: 0.8, // Ajusta el porcentaje de ancho de cada barra
                            categoryPercentage: 0.5 // Ajusta el espacio entre categorías
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                min: 0,  // Establece el valor mínimo del eje Y
                                max: 100, // Establece el valor máximo del eje Y
                                ticks: {
                                    stepSize: 10, // Define el intervalo entre valores
                                //beginAtZero: true
                                
                                }
                            }
                        }
                    }
                });
            });
    </script>
</body>
</html>
