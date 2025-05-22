<?php

require_once('./config.php');

class CConexion {

    static function ConexionDB(){
        $host = $_ENV['HOST_NAME'];
        $dbname = "prodventas";
        $username = "UserSis";
        $password = "Sistemas";

        try {
            $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            //echo "Conexión correcta";
        } catch (PDOException $exp) {
            echo "No se pudo conectar: " . $exp->getMessage();
            return null;
        }

        return $conn;
    }

    

}
?>
