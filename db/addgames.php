<?php

    session_start();

    if((!isset($_SESSION['useronline'])) || ((isset($_SESSION['useronline'])) && ($_SESSION['useronline'] == true) && ($_SESSION['user_type'] == 'user'))){
        header('Location: ../index.php');
        exit();
    }

    $gameTitle = $_POST['game-title'];
    $gamePlatform = $_POST['game-platform'];
    $gameDateWorld = $_POST['game-date-world'];
    $gameDatePl = $_POST['game-date-pl'];
    $gameType = $_POST['game-type'];
    $gameProducer = $_POST['game-producer'];
    $gamePublisher = $_POST['game-publisher'];
    $gameDistributor = $_POST['game-distributor'];
    $gameDescription = $_POST['game-description'];
    $gameProcessor = $_POST['game-processor'];
    $gameGraphic = $_POST['game-graphic'];
    $gameRam = $_POST['game-ram'];
    $gameSystem = $_POST['game-system'];
    $gameDirectx = $_POST['game-directx'];
    $gameSpace = $_POST['game-space'];
    $addDate = date('Y-m-d H:i:s');

    require_once "connect.php";

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno!=0){

        $_SESSION['notadd'] = 'Nie udało się dodać gry do bazy. Spróbuj ponownie.';
        header('Location: ../admins/admins.php?id=baza_gier');
        exit();

    } else {
        $addresoult = $connection->query("INSERT INTO games VALUES (NULL, '$gameTitle', '$gamePlatform', '$gameDateWorld', '$gameDatePl', '$gameType', '$gameProducer', '$gamePublisher', '$gameDistributor', '$gameDescription', '$gameProcessor', '$gameGraphic', '$gameRam', '$gameSystem', '$gameDirectx', '$gameSpace', '$addDate')");

        if($addresoult){
            $_SESSION['addsuccess'] = 'Gra pomyślnie dodana do bazy.';
            header('Location: ../admins/admins.php?id=baza_gier');
            exit();
        }
    }

    $connection->close();

?>
