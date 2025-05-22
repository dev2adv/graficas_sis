<?php
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);

    if (session_status() == PHP_SESSION_NONE) { 
        session_start(); }

        require_once "Conexion.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST['usuario'])) {
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
    
        $con = CConexion::ConexionDB();
    
        // Puedes cambiar el nombre del parámetro a algo sin caracteres especiales como ":password"
        $consulta = "SELECT * FROM usuarios WHERE us_email = :usuario AND us_clave = :password";
        //var_dump($con);
        $resultado = $con->prepare($consulta);
        
        $resultado->bindParam(':usuario', $usuario);
        $resultado->bindParam(':password', $contraseña); // Cambia el parámetro a "password"
        //var_dump($resultado);
        $resultado->execute();
    
        $usuario_verificado = $resultado->fetch(PDO::FETCH_ASSOC);
    
        if ($usuario_verificado) {
            $_SESSION['usuario'] = $usuario;
            header("Location: ini.php");
            exit;
        } else {
            echo "Credenciales incorrectas.";
        }
    }
    ?>