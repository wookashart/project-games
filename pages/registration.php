<div class="register-new-user">
<h1>Rejestracja</h1>
    <form method="POST" action="php/userregistry.php">
        <div class="form-line">
            <div class="form-left-column">
                <label>Login *</label>
            </div>
            <div class="form-right-column">
                <input type="text" name="nick">
            </div>
            <?php
                if(isset($_SESSION['e_nick'])){
                    echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                    unset($_SESSION['e_nick']);
                }
            ?>
        </div>
        <div class="form-line">
            <div class="form-left-column">
                <label>Płeć</label>
            </div>
            <div class="form-right-column">
                <input type="radio" value="Mężczyzna" name="plec" checked><span>Mężczyzna</span>
            </div>
        </div>
        <div class="form-line">
            <div class="form-left-column">
                <label></label>
            </div>
            <div class="form-right-column">
                <input type="radio" value="Kobieta" name="plec"><span>Kobieta</span>
            </div>
        </div>
        <div class="form-line">
            <div class="form-left-column">
                <label>Data urodenia</label>
            </div>
            <div class="form-right-column">
                <input type="date" name="data">
            </div>
        </div>
        <div class="form-line">
            <div class="form-left-column">
                <label>Miejscowość</label>
            </div>
            <div class="form-right-column">
                <input type="text" name="miejscowosc">
            </div>
        </div>
        <div class="form-line">
            <div class="form-left-column">
                <label>Email *</label>
            </div>
            <div class="form-right-column">
                <input type="email" name="email">
            </div>
            <?php
                if(isset($_SESSION['e_email'])){
                    echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                    unset($_SESSION['e_email']);
                }
            ?>
        </div>
        <div class="form-line">
            <div class="form-left-column">
                <label>Hasło *</label>
            </div>
            <div class="form-right-column">
                <input type="password" name="password1">
            </div>
            <?php
                if(isset($_SESSION['e_password'])){
                    echo '<div class="error">'.$_SESSION['e_password'].'</div>';
                    unset($_SESSION['e_password']);
                }
            ?>
        </div>
        <div class="form-line">
            <div class="form-left-column">
                <label>Powtórz hasło *</label>
            </div>
            <div class="form-right-column">
                <input type="password" name="password2">
            </div>
        </div>
        <div class="form-line">
            <input type="checkbox" name="regulamin"><label>* Akceptuję warunki <a href="index.php?action=regulamin">regulaminu</a></label>
            <?php
                if(isset($_SESSION['e_regulamin'])){
                    echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                    unset($_SESSION['e_regulamin']);
                }
            ?>
        </div>
        <div class="form-line">
            <input type="checkbox" name="zgoda"><label>Wyrażam zgodę na przetwarzanie danych osobowych w celach marketingowych i celem otrzymywania informacji handlowych drogą elektroniczną</label>
        </div>
        <div class="g-recaptcha" data-sitekey="6LcLmDAUAAAAAG4CnGNVLRPlHs9ou04x-xXLiA7D"></div>
        <?php
                if(isset($_SESSION['e_bot'])){
                    echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
                    unset($_SESSION['e_bot']);
                }
            ?>
        <input type="submit" value="Zarejestruj się">
    </form>
    <p class="need-to-registration">Pola oznaczone * są wymagane do rejestracji</p>
</div>