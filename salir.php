<?php

    // Iniciar la sesión
    session_start();
    
    // Destruir todas las variables de sesión
    $_SESSION = array();
    
    // Eliminar la cookie de sesión
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destruir la sesión
    session_destroy();
    header('Location: index.php');
?>
