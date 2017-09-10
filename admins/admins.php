<?php

    session_start();

    if((!isset($_SESSION['useronline'])) || ((isset($_SESSION['useronline'])) && ($_SESSION['useronline'] == true) && ($_SESSION['user_type'] == 'user'))){
        header('Location: ../index.php');
        exit();
    }

    $admins_panel = (isset($_GET['id'])) ? $_GET['id'] : 'admins';


?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Panel Administratora</title>
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/font-awesome.css">
        <link href="https://fonts.googleapis.com/css?family=Oswald:400,700|Roboto:400,400i,900,900i&amp;subset=latin-ext" rel="stylesheet">
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body class="admin-panel">
        <div class="admin-panel-conteiner">
            <div class="left-panel">
                <ul>
                    <li><img src="../img/icons/home.svg"><a href="../index.php">Strona główna</a></li>
                    <li><img src="../img/icons/game-controller.svg"><a href="admins.php?id=baza_gier">Baza gier</a></li>
                    <li><img src="../img/icons/browser.svg"><a href="admins.php?id=baza_artykuly">Artykuły</a></li>
                    <li><img src="../img/icons/notepad.svg"><a href="admins.php?id=baza_poradniki">Poradniki</a></li>
                    <li><img src="../img/icons/users.svg"><a href="admins.php?id=baza_users">Zarządzanie kontami</a></li>
                    <li><img src="../img/icons/switch.svg"><a href="../php/logout.php">Wyloguj się</a></li>
                </ul>
            </div>
            <div class="right-panel">
                <?php
                    switch($admins_panel){
                        case 'admins' : include 'adminpanel.php'; break;
                        case 'baza_gier' : include 'admingames.php'; break;
                        case 'baza_artykuly' : include 'adminarticles.php'; break;
                        case 'baza_poradniki' : include 'admintutorials.php'; break;
                        case 'baza_users' : include 'adminusers.php'; break;
                        default : include 'adminpanel.php'; break;
                    }
                ?>
            </div>
        </div>
        <script src="../js/jquery-3.1.1.min.js"></script>
        <script src="../js/main.js"></script>
    </body>
</html>