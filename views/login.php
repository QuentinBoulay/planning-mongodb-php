<h1 class="center">Connexion</h1>
<hr />
<section id="login">
    <?php if (isset($_SESSION["info"]["message"]) && $_SESSION["info"]["message"] !== "") { ?>
        <div id="info-session" class="<?= isset($_SESSION["info"]["status"]) ? $_SESSION["info"]["status"] : "" ?>">
            <?= $_SESSION["info"]["message"] ?>
        </div>
    <?php } ?>
    <form action="index.php?ctrl=User&action=doLogin" method="POST" class="login-form">
        <label>Mail :</label>
        <input type="email" name="email" placeholder="Mail.." />
        
        <label>Mot de passe :</label>
        <input type="password" name="password" placeholder="Mot de passe.." />
        
        <input type="submit" class="submit-btn" value="Créer/Valider">
        
        <a href="index.php?ctrl=User&action=register">S'inscrire</a>
    </form>
</section>
</body>

<?php unset($_SESSION["info"]); ?>

</html>