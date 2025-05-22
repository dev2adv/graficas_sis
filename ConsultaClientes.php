<?php
session_start();
include_once("Conexion.php");
include_once("cabecera.php");
//include_once("seguiDet.php");
$con=CConexion::ConexionDB();
//var_dump($_POST);
if (!isset($_SESSION['usuario'])) {
    echo "Usuario no autenticado.";
    exit;
}
//echo $_SESSION['usuario'];
$usuario = $_SESSION['usuario'];

 //echo "en el if";
    
    $sqli=" select distinct UPPER(consignatario) AS cliente  
    FROM public.embarqueventas where UPPER(consignatario) LIKE UPPER('%a%') and vendedor='$usuario' 
    ORDER BY 1 ASC ";
    $tipos=$con->query($sqli);
    $tipo=$tipos->fetchAll();
    //print_r($tContenedor);


?>
   

<link rel="stylesheet" href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
<!--link rel="stylesheet" href="estilos.css"-->
<link rel="stylesheet" href="style.css" />
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="sistemacl.js"></script>

    <div class="card border-danger">
        <div class="card-header border-danger bg-danger text-white">Seguimiento de Clientes</div>
        <div class="card-body ">
        <!--form action="" method="post"> 
            <div class="row">
                <div class=" col-md-12">
                    <label for="inputCity" class="form-label form-control-sm text-danger">Cliente</label>
                    <input type="text" autofocus class="form-control form-control-sm" id="clien" name="clien" autocomplete="off" onkeyup="autocompletarConsigV()" style="text-transform:uppercase" >
                    <ul id="lista_clie"></ul>
                </div>
                <br>
                <div class=" col-md-4">
                    <button class="btn btn-danger" onclick="seguiEdit.php">BUSCAR</button>
                </div>
            </div>
        </form-->
        
     
      <div class="col-md-4">
        <form action="" method="POST">    
        <label for="inputState" class="form-label form-control-sm text-danger">CLIENTES:</label>
            <select id="tipos" name="tipo" class="form-select form-select-sm text-uppercase" autocomplete="off" onkeyup="autocompletarConsigV()" action="submit" >
                <option selected> </option>
                <?php foreach ($tipo as $tContenedores) { ?>	
                    <option  style="text-transform:uppercase" <?php
                            if (!empty($tipos)) {
                                    if (in_array($tContenedores['cliente'],$tipo)) {
                                    echo 'selected';
                                    }
                            }
                            ?>
                    value="<?php echo $tContenedores['cliente']; ?>" ><?php echo $tContenedores['cliente']; ?>
                    </option>  
                <?php } ?>
            </select>
            <ul id="lista_clie"></ul>
            
        </form>
     </div>
     <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    
     <i onclick="PDFC()" class='btn btn-outline-danger'  >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
        <path d="M5.523 12.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z"/>
        <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.7 11.7 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.86.86 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.84.84 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.8 5.8 0 0 0-1.335-.05 11 11 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.24 1.24 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a20 20 0 0 1-1.062 2.227 7.7 7.7 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103"/>
        </svg></i>
                </div>
                <br>
       <!-- TABLA -->
    <div class="table-responsive-sm align-middle">
        <table id="casos" class="table table-hover table-bordered ">
            <thead>
                
            </thead>
            <tbody class="table" id="tablaC">
            
            </tbody>
        </table>
    </div>
    
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
                    url: 'seguiDet.php',
                    method: 'GET',
                    data: { ges: tiposId },
                    success: function(data) {
                        console.log(data);
                        $('#casos tbody').html(data);
                    }
                });
            });
        });

        
    </script>
    <script>
        function PDFC() {
            const mes = $('#tipos').val();
            window.location.href = 'ConsultaClientesPdf.php?mes=' + encodeURIComponent(mes) ;
            //window.location.href = 'pdf1.php;
        }
    </script>

<?php include_once("pie.php"); ?>
        