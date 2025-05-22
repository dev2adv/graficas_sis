<?php
session_start();
include_once("Conexion.php");
include_once("cabecera.php");
//include_once("estadistica1_cod.php");
$con=CConexion::ConexionDB();

if (!isset($_SESSION['usuario'])) {
    echo "Usuario no autenticado.";
    exit;
}
//echo $_SESSION['usuario'];
$usuario = $_SESSION['usuario'];
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

<body>
    <div class="card border-danger">
        <div class="card-header border-danger bg-danger text-white">Estadíticas de Ventas</div>
        <div class="card-body " style="justify-content: center;">
            <div class="row">
            <div class="col-md-4" >
                    <table class="table table-hover" id="registros">
                        <thead>
                            <th >Nro</th>
                            <th >Sucursal</th>
                        </thead>
                        <tbody >
                            
                        </tbody>
                    </table>
                    <table class="table table-hover" id="tablaSecundaria" style="display: none;">
                        <thead>
                           
                        </thead>
                        <tbody>
                            <!-- Aquí se insertarán los datos dinámicamente -->
                        </tbody>
                    </table>
            </div>
            <div class="col-md-8 post-thumb-img-content post-thumb" >
            <canvas id="ventasChart" width="150" height="50" ></canvas>
            </div>
            </div>
        </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
$(document).ready(function() {
    $.ajax({
                url: "estadistica1_cod.php", // Archivo que obtiene los datos
                method: "GET",
                success: function(response) {
                    $("#registros tbody").html(response); // Insertar datos en la tabla
                },
                error: function(xhr, status, error) {
                    console.error("Error al cargar los datos:", error);
                }
            });
});



$(document).on("click", "#registros tbody tr", function() {
    var varid = $(this).data("id"); // Obtener el ID de la fila
    console.log("para mostrar la tabla extra");
    console.log($(this).data("id"));
    $.ajax({
        url: "estadistica2_cod.php",
        method: "GET",
        data: { id: varid },
        success: function(response) {
            $("#tablaSecundaria tbody").html(response);
            $("#tablaSecundaria").show(); // Mostrar la tabla secundaria
        }
    });
});


        console.log("inicio de la grafica");
        fetch('estadistica_cod.php')
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
                            label: 'Ventas totales ADVANCELINE SRL',
                            data: cantidades,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    </script>
</body>
</html>
