<?php

    session_start();

    require_once "../db/connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    $score = $_POST['played-slider'];
    $gameHour = $_POST['played-hour'];
    $gameMinut = $_POST['played-minut'];
    $idGame = $_SESSION['gameId'];
    $idUser = $_SESSION['id'];

    if ($gameHour != null) {
        $gameHour = $_POST['played-hour'];
    } else {
        $gameHour = 0;
    }

    if ($gameHour != null) {
        $gameMinut = $_POST['played-minut'];
    } else {
        $gameMinut = 0;
    }

    if(isset($connection)) {

        $haveGame = $connection->query("SELECT * FROM users_library WHERE id_user = $idUser AND id_game = $idGame");
        $alredyHave = $haveGame->num_rows;
        $game = $haveGame->fetch_assoc();

        if($alredyHave == 0){
            $addGameLibr = $connection->query("INSERT INTO users_library VALUES (NULL, '$idUser', '$idGame', 'brak', 'brak', 'no', 'yes', '$gameHour', '$gameMinut', '$score')");    
            header('Location: ../index.php?action=gamedetail&id='.$idGame);
            exit();

            } else {

                if($game['finish'] == 'no'){
                    $addGameLibr = $connection->query("UPDATE users_library SET finish = 'yes', finish_game_h = '$gameHour', finish_game_m = '$gameMinut', rating = '$score' WHERE id_user = $idUser AND id_game = $idGame");
                    header('Location: ../index.php?action=gamedetail&id='.$idGame);
                    exit();
                } else {
                    header('Location: ../index.php?action=gamedetail&id='.$idGame);
                    exit();
                }
            }
        
    } else {
        $_SESSION['connect-error'] = 'Przepraszamy, nie można w tej chwili nawiązać połączenia z bazą. Spróbuj za chwilę.';
    }



    $connection->close();

?>