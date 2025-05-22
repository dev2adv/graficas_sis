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
//$usuarios = array("IVAlan", "QLuis","IVKriss","MMLaura","LQJhovana","PLHector");
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
<style>
    .modal-body {
    /*max-height: 700px;*/
    overflow-x: auto;
    overflow-y: auto;
}

</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <div class="card border-danger">
        <div class="card-header border-danger bg-danger text-white">Lista General de Ventas por Gestión</div>
        <div class="card-body ">
        <div class="row">
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
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    
                    <i onclick="REPEXG()" id="miexcel"  name = "miexcel" class='btn btn-outline-success'  >
                    <i class="bi bi-file-earmark-spreadsheet-fill" disabled></i>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet-fill" viewBox="0 0 16 16">
                    <path d="M6 12v-2h3v2z"/>
                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M3 9h10v1h-3v2h3v1h-3v2H9v-2H6v2H5v-2H3v-1h2v-2H3z"/>
                    </svg></i>
                </div>
        </div>
            <br>
       <!-- TABLA -->
       <table id="registros" class="table table-hover table-danger">
        <thead>
            
        </thead>
        <tbody class="table" id="tabla">
        </tbody>
       </table>
       <!-- MODAL -->
       <div class="modal" id="mi-modal" width="1600" >
            <div class="modal-dialog border-danger modal-xl ">
                <div class="modal-content  border-danger modal-xl">
                    <div class="modal-header  border-danger modal-xl">
                        <h5>Files Registrados</h5>
                    </div>
                    <div class="modal-body border-danger modal-xl formBody">
                            <div class="row">
                            <div class="col-md-2">  
                                <label for="ro">Nro:</label>
                                <input class="form-control form-control-sm" type="text" name="nro" aria-label=".form-control-sm example" readonly>
                            </div>
                            <div class="col-md-7">  
                                <label for="ro">Vendedor:</label>
                                <input class="form-control form-control-sm" type="text" name="vendedor" aria-label=".form-control-sm example" readonly>
                            </div>
                            <div class="col-md-3">  
                                <label for="ro">Periodo:</label>
                                <input class="form-control form-control-sm" type="text" name="periodo" aria-label=".form-control-sm example" readonly>
                            </div>
                            <br>
                            <br>
                            <br>
                            <!-- TABLA -->
                            <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm align-middle" id="registrosv">
                                <thead class="header">
                                </thead>
                                <tbody class="table" id="tabla">
                                </tbody>
                            </table>
                            
                            </div>
                    </div>
                    </div> 
                </div>
                <div class="modal-footer modal-xl">
                    <button class="btn btn-danger" id="btnCancelar" data-dismiss="modal" onclick="$('#mi-modal').modal('hide');" >Cancelar</button>
                </div>
                </div>
        
        </div>
        <!-- FIN MODAL -->

    <script>
        $(document).ready(function() {
    console.log("Script cargado correctamente.");

    // Cargar datos en la tabla con AJAX al cambiar el select
    $(document).ready(function() {
    $("#tipos").change(function() {
        var tiposId = $(this).val();
        
        $.ajax({
            url: 'ReporteGral_cod.php',
            method: 'GET',
            data: { ges: tiposId },
            success: function(data) {
                $('#registros tbody').html(data);

                // Volver a añadir eventos de clic a las filas después de actualizar la tabla
                $('#registros tbody').on("click", "tr", function() {
                    let id = $(this).attr("data-id");
                    let vend = $(this).attr("data-vendedor");

                    if (id && id.trim() !== "") {
                        console.log("Mostrando el modal con ID:", id, " periodo:", tiposId, " vendedor:", vend);

                        // Llamada AJAX con $.ajax() para obtener datos del modal
                        $.ajax({
                            url: 'listaFileVend.php',
                            type: 'GET',
                            data: { id: id, periodo: tiposId },
                            success: function(response) {
                                $('#registrosv tbody').html(response); // Inserta las filas en la tabla dentro del modal
                                
                                // Asignar valores a los campos del modal
                                $("#mi-modal").find("input[name='nro']").val(id);
                                $("#mi-modal").find("input[name='vendedor']").val(vend);
                                $("#mi-modal").find("input[name='periodo']").val(tiposId);
                                
                                $("#mi-modal").modal("show"); // Mostrar el modal
                            },
                            error: function(xhr, status, error) {
                                console.error("Error en la respuesta:", error);
                            }
                        });
                    } else {
                        console.log("Fila sin ID, modal no se mostrará.");
                    }
                });
            }
        });
    });
});


    // Manejo del foco al abrir y cerrar el modal
    $('#mi-modal').on('shown.bs.modal', function () {
        $('#btnCancelar').focus(); // Establece el foco en el botón dentro del modal
    });

    $('#mi-modal').on('hidden.bs.modal', function () {
        $('#tipos').focus(); // Mueve el foco a un elemento fuera del modal
    });

    // Función para generar el reporte
    function REPEXG() {
        const mes = $('#tipos').val();
        console.log(mes);
        if (mes !== "") {
            const url = "ReporteGralEx.php?mes=" + encodeURIComponent(mes); 
            location.replace(url);
        } else {
            alert("Debe seleccionar un periodo para generar el archivo");
        }
    }
});

    </script>
<?php include_once("pie.php"); ?>
        