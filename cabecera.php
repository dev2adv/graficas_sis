<?php
    
    include('login.php');
    include('reg_venta_cod.php');
    //include('guardar.php');
    
    include_once("Conexion.php");
    $con = CConexion::ConexionDB();
   
    //var_dump();
    $usuario = $_SESSION['usuario'];

    $sql="  SELECT UPPER( b.trabajador) AS TRABAJADOR ,b.email,UPPER(b.cargo) AS CARGO ,c.sucursal,d.rol_nombre,d.rol_id,
                '(+591) '||b.celular as celular, c.telefono, c.direccion  
            FROM usuarios a, trabajador b, cat_sucursal c, roles d
            where a.per_id=b.id and us_email= :user 
            and b.sucursal=c.id 
            and a.rol_id=d.rol_id ";
    $consulta=$con->prepare($sql);
    //echo $ida;
    $consulta->bindParam(':user',$usuario);
    $consulta->execute();
    $usnombre=$consulta->fetch(PDO::FETCH_ASSOC);
    //print_r( $usnombre);
    $rol_id = $usnombre['rol_id'];
    if (!isset($_SESSION['usuario'])) {
        echo "no hay usuario";
        header('Location: index.php');
    }



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>ADVANCELINE SRL</title>
    <link rel="shortcut icon" href="images/SoloA Logo.png " type="image/x-icon" />
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <STYle>
            @font-face {
    font-family: 'Lato';
    src: url('/fonts/Lato-Light.ttf') format('ttf');
}
    </STYle>
</head>
<body >
    <section>
        <br>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <a class="nav-link active text-danger" aria-current="page" href="ini.php">Inicio</a>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-danger" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ventas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-danger" href="procesar_carta.php">Carta Presentación</a></li>
                            <li><a class="dropdown-item text-danger" href="reg_venta2.php">Registro</a></li>
                            <li><a class="dropdown-item text-danger" href="Registro.php">Reporte</a></li>
                        </ul>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-danger" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Clientes
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-danger" href="#">Cliente Nuevo</a></li>
                            <li><a class="dropdown-item text-danger" href="ConsultaClientes.php">Seguimiento</a></li>
                        </ul>
                        </li>
                        <li class="nav-item dropdown" id="menusup" >
                        <a class="nav-link dropdown-toggle text-danger" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Supervisor
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-danger" href="estadisticaSuc.php">Gráfica Ventas</a></li>
                            <li><a class="dropdown-item text-danger" href="ReporteSuc.php">Reporte Sucursal</a></li>
                        </ul>
                        </li>
                        <li class="nav-item dropdown" id="menuger" >
                        <a class="nav-link dropdown-toggle text-danger" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Gerencia
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-danger" href="ReporteGral.php">Reporte General</a></li>
                            <li><a class="dropdown-item text-danger" href="estadistica1.php">Gráfica Ventas</a></li>
                            <li><a class="dropdown-item text-danger" href="#">Gráfica Ventas Sucursal</a></li>
                            <li><a class="dropdown-item text-danger" href="reg_venta1.php">Registro File</a></li>
                        </ul>
                        <li class="nav-item">
                        <a class="nav-link active text-danger" aria-current="page" href="guiaAdv.php">Teléfonos</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link text-danger" onclick="cerrarSesion()">Salir</a>
                        </li>
                    </ul>
                    
                    <ul class="navbar-nav me-auto mb-4 mb-lg-0">
                        <img src="images/NUEVO.png" width="30%" height="20%"  >
                    </ul>
                    <span class="navbar-text" style="font-size: 11px; text-align: center; font-weight: bold; color:rgb(5, 5, 5);">
                        <div ><?php echo $usnombre['trabajador'] ?></div>    
                        <div ><?php echo $usnombre['cargo'] ?></div>    
                        <div><?php echo $usnombre['email'] ?></div>
                        <div id="suc"><?php echo $usnombre['sucursal'] ?></div>  
                        <div><?php echo $usuario.' - '.$usnombre['rol_nombre'] ?></div>  
                    </span>
                    
                </div>
            </div>
        </nav>
    </section>
   
    <script src="cerrar.js"></script>
    <script>
        // Obtener el valor del rol desde PHP
        const rol_id = <?php echo $rol_id; ?>; // Paso de datos PHP a JavaScript

        // Función para evaluar la condición
        function evaluarCondicion() {
            // Validar si el rol_id está permitido
            const cumpleCondicion = [0,1,2].includes(rol_id);

            const menu = document.getElementById('menusup');
            if (cumpleCondicion) {
                // Habilitar el menú
                Array.from(menu.children).forEach(item => {
                    item.classList.remove('disabled');
                });
            } else {
                // Deshabilitar el menú
                Array.from(menu.children).forEach(item => {
                    item.classList.add('disabled');
                });
            }

            // Validar si el rol_id está permitido
            const cumpleCondiciong = [0,1].includes(rol_id);

            const menug = document.getElementById('menuger');
            if (cumpleCondiciong) {
                // Habilitar el menú
                Array.from(menug.children).forEach(item => {
                    item.classList.remove('disabled');
                });
            } else {
                // Deshabilitar el menú
                Array.from(menug.children).forEach(item => {
                    item.classList.add('disabled');
                });
            }



        }

        // Ejecutar la función al cargar la página
        document.addEventListener("DOMContentLoaded", evaluarCondicion);
    </script>
