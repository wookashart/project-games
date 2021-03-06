<?php

    if((!isset($_SESSION['useronline'])) || ((isset($_SESSION['useronline'])) && ($_SESSION['useronline'] == true) && ($_SESSION['user_type'] == 'user'))){
        header('Location: ../index.php');
        exit();
    }

    
    require_once "../db/connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

?>

<div class="games-administration">
    <section class="admin-add-new-game">
        <h2>Dodaj DLC do bazy</h2>
        <?= $_SESSION['addalert'] ?>
        <form method="POST" action="../php/adddlc.php" enctype="multipart/form-data">
            <div class="game-data dlc-data">
                <label>
                    <span>Gra, do której jest dodatek</span>
                    <select name="dlc-game" class="one-choose-select">
                        <?php

                            $con = $connection->query("SELECT * FROM games ORDER BY tytul ASC");

                            while($row = $con->fetch_assoc()) {
                                echo '<option value="'.$row['id_games'].'">'.$row['tytul'].'</option>';
                            }

                        ?>
                    </select>
                </label>
                <label>
                    <span>Tytuł oryginalny</span><input type="text" name="dlc-title">
                </label>
                <label>
                    <span>Tytuł PL</span><input type="text" name="dlc-title-pl">
                </label>
                <label>
                    <span>Platforma</span>
                    <select multiple name="dlc-platform[]">
                        <option value="3DO">3DO</option>
                        <option value="Amiga">Amiga</option>
                        <option value="Arcade">Arcade</option>
                        <option value="Atari2600">Atari 2600</option>
                        <option value="Atari5200">Atari 5200</option>
                        <option value="Atari7800">Atari 7800</option>
                        <option value="DC">Dreamcast</option>
                        <option value="GB">Gameboy</option>
                        <option value="GBA">Gameboy Advance</option>
                        <option value="GBC">Gameboy Color</option>
                        <option value="GC">Gamecube</option>
                        <option value="GG">Gamegear</option>
                        <option value="Genesis">Genesis</option>
                        <option value="Jaguar">Jaguar</option>
                        <option value="Macintosh">Macintosh</option>
                        <option value="MasterSystem">Master System</option>
                        <option value="MOB">Mobile</option>
                        <option value="N-Gage">N-Gage</option>
                        <option value="NeoGeo">NeoGeo</option>
                        <option value="NeoGeoPocked">NeoGeo Pocked</option>
                        <option value="NES">NES</option>
                        <option value="N64">Nintendo 64</option>
                        <option value="3DS">Nintendo 3DS</option>
                        <option value="DS">Nintendo DS</option>
                        <option value="Switch">Nintendo Switch</option>
                        <option value="Wii">Nintendo Wii</option>
                        <option value="WiiU">Nintendo Wii U</option>
                        <option value="PC">PC</option>
                        <option value="PS">Playstation</option>
                        <option value="PS2">Playstation 2</option>
                        <option value="PS3">Playstation 3</option>
                        <option value="PS4">Playstation 4</option>
                        <option value="PSP">PSP</option>
                        <option value="PSV">Playstation Vita</option>
                        <option value="Saturn">Saturn</option>
                        <option value="S32X">Sega 32X</option>
                        <option value="SCD">Sega CD</option>
                        <option value="SN">Super Nintendo</option>
                        <option value="TG16">TurboGrafx 16</option>
                        <option value="Vectrex">Vectrex</option>
                        <option value="VB">Virtual Boy</option>
                        <option value="XBOX">Xbox</option>
                        <option value="X360">Xbox 360</option>
                        <option value="XONE">Xbox One</option>
                    </select>
                </label>
                <label>
                    <span>Data premiery - świat</span><input type="date" name="dlc-date-world">
                </label>
                <label>
                    <span>Data premiery - Polska</span><input type="date" name="dlc-date-pl">
                </label>
                <label>
                    <span>Opis gry</span><textarea type="input" name="dlc-description"></textarea>
                </label>
                <label>
                    <span>Okładka</span><input type="file" name="dlc-cover">
                </label>
            </div>
            <input type="submit" value="Dodaj grę" name="submit">
        </form>
    </section>
</div>
<?php $_SESSION['addalert'] = ''; ?>