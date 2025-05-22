<?php
 include('cabecera.php');

include_once("Conexion.php");
//session_start();
if (!isset($_SESSION['usuario'])) {
    echo "Usuario no autenticado.";
    exit;
}

    $usuario = $_SESSION['usuario'];

    $usuario = $_SESSION['usuario'];
    $sqli="SELECT DISTINCT CAST(CONCAT(CAST(EXTRACT(year FROM fllegada) AS INT), '', LPAD(CAST(EXTRACT(MONTH FROM fllegada) AS INT)::text, 2, '0')) AS INT) AS gestion FROM embarqueventas WHERE vendedor='$usuario' ORDER BY 1 DESC ";
    $tipos=$con->query($sqli);
    $tipo=$tipos->fetchAll();

    
?>


    <link rel="stylesheet" href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    
    <div class="card border-danger">
        <div class="card-header border-danger bg-danger text-white">Lista General de Embarques por Gestión</div>
    <div class="card-body ">
    <div class="col-md-4">
            <form action="" method="post">    
            <label for="inputState" class="form-label form-control-sm text-danger">GESTIÓN:</label>
                <select id="tipos" name="tipo" class="form-select form-select-sm text-uppercase" onchange="mes(this.value);"  >
                    <option selected>Seleccion una gestión </option>
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
    <div class="py-4">
    <div class="col-md-4">
        <button type="button" id="modal" class="btn btn-primary" data-toggle="modal" data-target="#mi-modal" onclick="modal(0)" style="display:none;">Registrar</button>
    </div>
        
        <!-- TABLA -->
        <div class="row">
            <div class="table-responsive">
                
                <table class="table table-hover table-bordered table-sm align-middle table-responsive" style = "font-size: 08px;">
                    <thead class="header">
                        <tr class="table table-danger">
                            <th>RO</th>
                            <th>SERVICIO</th>
                            <th>TIPO DE TRANSPORTE</th>
                            <th>NAVIERA</th>
                            <th>PROVEEDOR</th>
                            <th>CONSIGNATARIO</th>
                            <th>MBL / BOOKING</th>
                            <th>NUMERO DE CONTENEDOR</th>
                            <th>TIPO DE CONTENEDOR</th>
                            <th>CANTIDAD DE CONTENEDOR</th>
                            <th>MERCANCIA O PRODUCTO</th>
                            <th>PUERTO ORIGEN</th>
                            <th>FECHA SALIDA</th>
                            <th>PUERTO LLEGADA</th>
                            <th>FECHA LLEGADA</th>
                            <th>VENTA TOTAL</th>
                            <th>COMPRA TOTAL</th>
                            <th>TOTAL PROFIT</th>
                            <th>T CONTABLE</th>
                            <th>OBSERVACIONES</th>
                            <th>NRO</th>
                            <th>EDITAR</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody class="table" id="tabla">
                    </tbody>
                </table>
            </div>
        </div>
        <!-- MODAL -->
        <div class="modal" id="mi-modal" width="1800" inert>
            <div class="modal-dialog modal-xl ">
                <div class="modal-content modal-xl">
                    <div class="modal-header modal-xl">
                        <h5>FORMULARIO</h5>
                    </div>
                    <div class="modal-body modal-xl formBody">
                        <iframe id='one' src="Formuario.php" frameborder="0" height="600" width="1100"></iframe>
                    </div>
                    <div class="modal-footer modal-xl">
                        <button class="btn btn-danger" id="btnCancelar" data-dismiss="modal" onclick="cerrar();" >Cancelar</button>
                        <button class="btn btn-success" onclick="FormSubmit($('#tipos').val());" type="button" id="btnregistro" data-dismiss="modal">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN MODAL -->
       
               
        <i  onclick="PDF()" class='btn btn-outline-danger'  >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
        <path d="M5.523 12.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z"/>
        <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.7 11.7 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.86.86 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.84.84 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.8 5.8 0 0 0-1.335-.05 11 11 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.24 1.24 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a20 20 0 0 1-1.062 2.227 7.7 7.7 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103"/>
        </svg></i>
        
        <i  onclick="REPEX()" class='btn btn-outline-success'  >
        <i class="bi bi-file-earmark-spreadsheet-fill"></i>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet-fill" viewBox="0 0 16 16">
        <path d="M6 12v-2h3v2z"/>
        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M3 9h10v1h-3v2h3v1h-3v2H9v-2H6v2H5v-2H3v-1h2v-2H3z"/>
        </svg></i>
</div>
    
    </div>
<!--/div-->
    <script src="codigo.js"></script>
    <script>
        document.getElementById('mi-modal').addEventListener('shown.bs.modal', function () {
            document.getElementById('btnCancelars').focus(); // Establece el foco en el botón dentro del modal.
        });

        document.getElementById('mi-modal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('tipos').focus(); // Mueve el foco a un elemento fuera del modal.
        });
        
        function mostrarModal2(xnro) {
            console.log("entra al modal2");
            $('#modal2').modal('show');
        };
        function mostrarDatos(mes) {
            $.ajax({
                url: 'reporte.php',
                type: 'GET',
                data: { mes: mes },
                success: function(data) {
                    $('#tabla').html(data);
                }
            });
        }

        

        function PDF() {
            const mes = $('#tipos').val();
            window.location.href = 'reporte.php?mes=' + encodeURIComponent(mes) + '&pdf=1';
            //window.location.href = 'pdf1.php;
        }

        function REPEX()
        {
            const mes = $('#tipos').val();
            console.log(mes);
            //console.log(document.getElementById("mes"));
            //const selectElement = document.getElementById("mes"); 
            //const selectedValue = selectElement.value;
            //console.log(selectedValue); 
            const url = "geraRep.php?mes=" + encodeURIComponent(mes); 
            location.replace(url);
            //alert("Reporte generado con éxito! RUTA ->  D:/Ventas/reporte.xls");
            //alert("Esta seguro de salir?");
            //window.location.href = "Registro.php";*/


        }
        

    </script>
