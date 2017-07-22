<?php

    if((!isset($_SESSION['useronline'])) || ((isset($_SESSION['useronline'])) && ($_SESSION['useronline'] == true) && ($_SESSION['user_type'] == 'user'))){
        header('Location: ../index.php');
        exit();
    }

?>

<div class="games-administration">
    <section class="admin-add-new-game">
        <h2>Dodaj nową grę do bazy</h2>
        <form method="POST">
            <div class="game-data">
                <label>
                    <span>Tytuł gry</span><input type="text" name="game-title">
                </label>
                <label>
                    <span>Platforma</span><input type="text" name="game-platform">
                </label>
                <label>
                    <span>Data premiery - świat</span><input type="date" name="game-date-world">
                </label>
                <label>
                    <span>Data premiery - Polska</span><input type="date" name="game-date-pl">
                </label>
                <label>
                    <span>Gatunek gry</span><input type="text" name="game-type">
                </label>
                <label>
                    <span>Producent</span><input type="text" name="game-producer">
                </label>
                <label>
                    <span>Wydawca</span><input type="text" name="game-publisher">
                </label>
                <label>
                    <span>Dystrybutor</span><input type="text" name="game-distributor">
                </label>
                <label>
                    <span>Opis gry</span><textarea type="input" name="game-description"></textarea>
                </label>
            </div>
            <div class="hardware-requirements">
                <p class="hardware-requirements-title">Wymagania sprzętowe</p>
                <label>
                    <span>Procesor</span><input type="text" name="game-processor">
                </label>
                <label>
                    <span>Karta graficzna</span><input type="text" name="game-graphic">
                </label>
                <label>
                    <span>Pamięć RAM</span><input type="text" name="game-ram">
                </label>
                <label>
                    <span>System operacyjny</span><input type="text" name="game-system">
                </label>
                <label>
                    <span>DirectX</span><input type="text" name="game-directx">
                </label>
                <label>
                    <span>Miejsce na dysku</span><input type="text" name="game-space">
                </label>
            </div>
            <input type="submit" value="Dodaj grę">
        </form>
    </section>
</div>