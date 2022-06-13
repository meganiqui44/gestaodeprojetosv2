<?php

    session_start();

    if(session_id() == '' || !isset($_SESSION) || session_status() != PHP_SESSION_ACTIVE || !isset($_SESSION["email"])) {
        header("Location: index.php");
    }

    echo '
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestão de Projetos</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles.css">
        <link rel="shortcut icon" href="images/favicon.webp" />
    ';

    header('Content-Type: text/html; charset=utf-8');

?>