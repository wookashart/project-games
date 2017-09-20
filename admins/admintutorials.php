<?php

    if((!isset($_SESSION['useronline'])) || ((isset($_SESSION['useronline'])) && ($_SESSION['useronline'] == true) && ($_SESSION['user_type'] == 'user'))){
        header('Location: ../index.php');
        exit();
    }
    
    require_once "../db/connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    $gamesConnect = $connection->query("SELECT * FROM games ORDER BY tytul");

    if (isset($_SESSION['tutalert']) && isset($_SESSION['tutalert']) == true){
        $alert = $_SESSION['tutalert'];
    } else {
        $alert = '';
    }

?>
<div class="new-tutorial-admins">
    <h2>Dodaj poradnik</h2>
    <?= $alert ?>
    <form method="POST" action="../php/addtutorial.php">
        <label class="tutorial-game-title">
            <span>Gra</span>
            <select name="tut-game">
                <?php

                    while($game = $gamesConnect->fetch_assoc()){
                        echo '<option value="'.$game['id_games'].'">'.$game['tytul'].'</option>';
                    }

                ?>
            </select>
        </label>
        <label class="tutorial-title">
            <span>Tytuł</span>
            <input type="text" name="tut-title">
        </label>
        <label class="tutorial-header">
            <span>Nagłówek</span>
            <textarea name="tut-header"></textarea>
        </label>
        <label class="tutorial-content">
            <span>Treść</span>
            <textarea name="tut-content"></textarea>
        </label>
        <input type="submit" class="base-btn">
    </form>
</div>
<?php $_SESSION['tutalert'] = ''; ?>