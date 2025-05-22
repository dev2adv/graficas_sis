<?php
    include('login.php');
?>


<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <title>ADVANCELINE SRL</title>
    <link rel="shortcut icon" href="images/SoloA Logo.png " type="image/x-icon" />
    <style>
        .contenedor {
            text-align: center;
            line-height: 20vh; /* Ajusta según sea necesario */
        }

        .contenedor img {
            vertical-align: middle;
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    
     <br>
     <br>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <br>
                <form action="login.php" method="post">
                    <div class="card border-danger">
                        <div class="card-header border-danger bg-danger text-white">INICIO DE SESION</div>
                            <div class="card-body">
                            <div class="mb-3">
                                <label for="usuario" class="form-label"><i class="zmdi zmdi-account material-icons-name">Usuario</label>
                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="usuario" />
                                
                            </div>
                            <div class="mb-3">
                                <label for="contraseña" class="form-label">Contraseña</label>
                                
                                <input type="password" class="form-control" name="contraseña" id="contraseña" placeholder="contraseña" />
                                
                            </div>
                            <button type="submit" class="btn btn-dark">Iniciar Sesion</button>
                           <br>
                           <br>
                            <div class="contenedor">
                                <img src="images/NUEVO.png" style="justifi"; alt="sing up image">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
