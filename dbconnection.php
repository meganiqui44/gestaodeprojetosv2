<?php
    function OpenDbConnection() {

        $useLocal = true;

        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $db = "gestaodeprojetosv2";

        if(!$useLocal) {
           
            $dbhost = "us-cdbr-east-05.cleardb.net";
            $dbuser = "b20784d45c4e23";
            $dbpass = "caa25093";
            $db = "heroku_89868715a2c9ce3";
            
        }

        $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Conexão falhou: %s\n". $conn -> error);
        $conn->set_charset("utf8");

        return $conn;

    }

    function CloseDbConnection($conn) {

        $conn -> close();
        
    }
?>