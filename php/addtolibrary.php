<?php
    session_start();
    require_once "../db/connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    $selectPlatform = $_POST['select-platform'];
    $idGame = $_SESSION['gameId'];
    $idUser = $_SESSION['id'];
    if (!isset($_POST['distribution'])) {
        $selectDistribution = 'brak';
    } else {
        $selectDistribution = $_POST['distribution'];
    }
    if(isset($connection)) {
        $haveGame = $connection->query("SELECT * FROM users_library WHERE id_user = $idUser AND id_game = $idGame");
        $alredyHave = $haveGame->num_rows;
        $game = $haveGame->fetch_assoc();
        if ($alredyHave == 0){
            $addGameLibr = $connection->query("INSERT INTO users_library VALUES (NULL, '$idUser', '$idGame', '$selectPlatform', '$selectDistribution', 'yes', 'no', 0, 0, 0)");
            header('Location: ../index.php?action=gamedetail&id='.$idGame);
            exit();
            } else {
                if($game['have'] == 'no'){
                    $addGameLibr = $connection->query("UPDATE users_library SET game_platform = '$selectPlatform', game_pc_platform = '$selectDistribution', have = 'yes' WHERE id_user = $idUser AND id_game = $idGame");
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