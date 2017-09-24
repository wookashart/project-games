<div class="contact-form">
    <h1>Kontakt</h1>
    <p class="contact-form-text">Masz pytanie? A może sugestię? Podziel się tym z nami!</p>
    <form method="POST" action="php/emailsend.php">
    <?php 
        if (isset($_SESSION['conterror']) && isset($_SESSION['conterror']) == true){
            echo $_SESSION['conterror'];
        }  
    ?>
        <label>
            <span>Imię / nick</span>
            <input type="text" name="contact-name">
        </label>
        <label>
            <span>Email</span>
            <input type="text" name="contact-email">
        </label>
        <label>
            <span>Temat</span>
            <input type="text" name="contact-title">
        </label>
        <label>
            <span>Treść</span>
            <textarea type="input" name="contact-message"></textarea>
        </label>
        <div class="submit">
            <input type="submit" class="base-btn" name="send" value="Wyślij">
        </div>
    </form>
</div>

<?php $_SESSION['conterror'] = ''; ?>
