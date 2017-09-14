<?php

    $userInfo = $connection->query("SELECT * FROM users WHERE id = {$_SESSION['id']}");
    $info = $userInfo->fetch_assoc();

    if($info['avatar'] == null){
        
        if ($info['plec'] == 'Kobieta'){
            $imgSrc = 'img/no-avatar-female.png';
        } else {
            $imgSrc = 'img/no-avatar-male.png';
        }
        
    } else {
        $imgSrc = 'db/useravatars/'.$info['avatar'];
    }

?>
<div class="edit-user-profile">
    <h2>Edytuj swój profil</h2>
    <div class="user-data">
        <form method="POST" action="./php/usereditavatar.php" enctype="multipart/form-data">
            <h4>Avatar</h4>    
            <div class="form-items-container">        
                <div class="current-avatar">
                    <img src="<?= $imgSrc ?>">
                </div>
                <div>
                    <p>Wybierz nowy avatar</p>
                    <input type="file" name="change-avatar" accept="image/*">
                </div>
                <div>Avatar powinien być w formacie jpg, png lub gif i nie przekraczać 500kb</div>
            </div>
            <?= $_SESSION['imgerr'] ?>
            <input type="submit" value="Zmień avatar" class="base-btn" name="submit">
        </form>
        <form method="POST" action="./php/usereditinfo.php">
            <h4>Dane</h4>    
            <div class="form-info-container">
                <div class="form-info-item">
                    <div class="form-info-item-header">Płeć</div>
                    <div class="form-info-item-content">
                        <?php
                        
                            if($info['plec'] == 'Kobieta'){
                                echo '<label><input type="radio" value="Mężczyzna" name="change-sex"><span>Mężczyzna</span></label><label><input type="radio" value="Kobieta" name="change-sex" checked><span>Kobieta</span></label>';
                            } else {
                                echo '<label><input type="radio" value="Mężczyzna" name="change-sex" checked><span>Mężczyzna</span></label><label><input type="radio" value="Kobieta" name="change-sex"><span>Kobieta</span></label>';
                            }
                        
                        ?>
                    </div>
                </div>
                <div class="form-info-item">
                    <div class="form-info-item-header">Miejscowość</div>
                    <div class="form-info-item-content">
                        <input type="text" name="change-place" value="<?= $info['miejscowosc'] ?>">
                    </div>
                </div>
                <div class="form-info-item">
                    <div class="form-info-item-header">Data urodzenia</div>
                    <div class="form-info-item-content">
                        <input type="date" name="change-birth" value="<?= $info['urodzony'] ?>">
                    </div>
                </div>
                <div class="form-info-item">
                    <div class="form-info-item-header">Email</div>
                    <div class="form-info-item-content">
                        <input type="text" name="change-email" value="<?= $info['email'] ?>">
                    </div>
                </div>
                <?= $_SESSION['emailerr'] ?>
            </div>
            <h4>Opis</h4>
            <div class="form-info-textarea">
                <textarea type="input" name="change-description"><?= $info['opis'] ?></textarea>
            </div>
            <div><input type="submit" value="Zapisz zmiany" class="base-btn"></div>
        </form>
        <form method="POST" action="./php/usereditpassword.php">
            <h4>Edycja hasła</h4>
            <div class="form-password-container">
                <div class="form-password-item">
                    <span class="form-password-item-header">Stare hasło:</span>
                    <input type="password" name="old-password" placeholder="Stare hasło">
                </div>
                <div class="form-password-item">
                    <span class="form-password-item-header">Nowe hasło:</span>
                    <input type="password" name="new-password" placeholder="Nowe hasło">
                </div>
                <div class="form-password-item">
                    <span class="form-password-item-header">Potwierdź hasło:</span>
                    <input type="password" name="new-password-repeate" placeholder="Potwierdź hasło">
                </div>
            </div>
            <div><input type="submit" value="Zmień hasło" class="base-btn"></div>
            <?= $_SESSION['passerr'] ?>
        </form>
    </div>
</div>

<?php $_SESSION['imgerr'] = ''; $_SESSION['emailerr'] = ''; $_SESSION['passerr'] = ''; ?>