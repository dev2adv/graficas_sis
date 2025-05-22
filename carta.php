<?php
 include('cabecera.php');

include_once("Conexion.php");
//session_start();
if (!isset($_SESSION['usuario'])) {
    echo "Usuario no autenticado.";
    exit;
}

    $con=CConexion::ConexionDB();

    $usuario = $_SESSION['usuario'];
    $sqli=" SELECT 
    DISTINCT  CAST(CONCAT(CAST(EXTRACT(year FROM fllegada) AS INT), '', LPAD(CAST(EXTRACT(MONTH FROM fllegada) AS INT)::text, 2, '0')) AS INT) AS gestion 
    FROM embarques  
    WHERE vendedor='$usuario'
    ORDER BY 1 DESC ";
    $tipos=$con->query($sqli);
    $tipo=$tipos->fetchAll();

    
?>


    <link rel="stylesheet" href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <div class="card border-danger">
        <div class="card-header border-danger bg-danger text-white">Carta de Presentación</div>
        <div class="card-body ">
        <div class="col-md-4">
        <form action="procesar_imp.php" method="post">
            <div class="form-floating mb-3">
                <input type="text" id="importadora" name="importadora" required class="form-control" placeholder="Nombre Importadora">
                <label for="floatingInput">Importadora</label>
            </div>
            <div class="form-floating">
            <input type="text" id="representante" name="representante"  class="form-control" placeholder="Representante">
            <label for="floatingInput">Representante</label>
            </div>
            <br>
            <div class="form-floating">
            <textarea class="form-control" id="mensaje" name="mensaje" placeholder="Escriba el contenido de la carta aqui" id="floatingTextarea2" style="height: 400px; width: 1800px">
            Un gusto saludarle por este medio.
            Nos complace presentar nuestra empresa de transporte internacional de carga, una compañía con una sólida trayectoria en el mercado y con una fuerte orientación de familia que guía nuestro enfoque en el servicio al cliente.
            Desde nuestros inicios, hemos estado comprometidos en ofrecer un servicio de calidad y personalizado, que se adapte a las necesidades de nuestros clientes. 
            Nos enorgullece contar con un equipo de profesionales altamente capacitados y con amplia experiencia en el sector logístico, lo que nos permite brindar soluciones eficientes y seguras para la gestión de cargas internacionales en importaciones y exportaciones como:
                                                •	TRANSPORTE MARÍTIMO DESDE CUALQUIER PARTE DEL MUNDO (CONTENEDORES Y CARGA SUELTA) 
                                                •	TRANSPORTE AÉREO DESDE CUALQUIER PARTE DEL MUNDO
                                                •	TRANSPORTE TERRESTRE HASTA SUS ALMACENES
                                                •	TRANSPORTE MULTIMODAL
                                                •	CARGA DE PROYECTOS
                                                •	SEGURO DE CARGA
                                                •	GIROS A PROVEEDORES DEL EXTERIOR
            Nos esforzamos por mantener una comunicación cercana y transparente con nuestros clientes, entendemos que cada carga es única y requiere de una atención personalizada. Además, nos caracterizamos por nuestra ética de trabajo y compromiso, implementando políticas que aseguran una gestión responsable.
            Confiamos en que nuestra empresa pueda ser de su agrado y satisfacer sus necesidades logísticas. Estamos a su disposición para cualquier consulta o solicitud de información adicional.
            Saludos cordiales

            Atentamente,
            </textarea>
           <br>
            <div class="form-floating">
            <textarea class="form-control"  placeholder="Coloque los datos del emisor aqui" style="height: 150px; width: 1000px" id="emisor" name="emisor">
            <p><?php echo $usnombre['trabajador']; ?></p>
            <p><?php echo $usnombre['cargo']; ?></p>
            <p><?php echo $usnombre['email']; ?></p>
            <p><?php echo $usnombre['celular']; ?></p>
            <p><?php echo $usnombre['telefono']; ?></p>
            <p><?php echo $usnombre['direccion']; ?></p>


            </textarea>
            <label for="floatingTextarea">Emisor</label>
            </div>
            <br>
            
            <button type="submit" class="btn btn-primary">Generar carta</button>
            <i  onclick="PDF()" class='btn btn-outline-danger'  >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                <path d="M5.523 12.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z"/>
                <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.7 11.7 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.86.86 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.84.84 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.8 5.8 0 0 0-1.335-.05 11 11 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.24 1.24 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a20 20 0 0 1-1.062 2.227 7.7 7.7 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103"/>
                </svg>
            </i>
        </form>
        </div>
        </div>
        </div>
</div>
<script>
    function PDF() {
    //const mes = $('#mes').val(); // Asegúrate de que 'mes' está definido
    const importadora = $('#importadora').val();
    const representante = $('#representante').val();

    // Construcción de la URL con múltiples parámetros
    const url = 'procesar_pdf.php?importadora=' + encodeURIComponent(importadora) + 
                '&representante=' + encodeURIComponent(representante) + 
                '&pdf=1';

    // Redireccionar con múltiples parámetros
    window.location.href = url;
}

</script>

