<h1 class="center">Inscription</h1>
<hr />
<section id="register">
    <?php if (isset($_SESSION["info"]["message"]) && $_SESSION["info"]["message"] !== "") { ?>
        <div id="info-session" class="<?= isset($_SESSION["info"]["status"]) ? $_SESSION["info"]["status"] : "" ?>">
            <?= $_SESSION["info"]["message"] ?>
        </div>
    <?php } ?>
    <form action="index.php?ctrl=User&action=doCreate" method="POST" class="register-form">
        <label>Mail :</label>
        <input type="email" name="email" placeholder="mail@exemple.com.." />

        <label>Mot de passe :</label>
        <input type="password" name="password" placeholder="Mot de passe.." />

        <label>Nom :</label>
        <input type="text" name="nom" placeholder="Jean Dupont.." />

        <input type="submit" class="submit-btn" value="Créer/Valider">

        <a href="index.php?ctrl=User&action=login">Se connecter</a>
    </form>
</section>
</body>

<?php unset($_SESSION["info"]); ?>

</html>