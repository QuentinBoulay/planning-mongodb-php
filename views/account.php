<h1>Mon compte</h1>
<hr>
<p><b>ID :</b> <?= $_SESSION["user"]->getId() && !empty($_SESSION["user"]->getId()) ? $_SESSION["user"]->getId() : "N/A" ?></p>
<p><b>Nom :</b> <?= $_SESSION["user"]->getNom() && !empty($_SESSION["user"]->getNom()) ? $_SESSION["user"]->getNom() : "N/A" ?></p>
<p><b>E-mail :</b> <?= $_SESSION["user"]->getEmail() && !empty($_SESSION["user"]->getEmail()) ? $_SESSION["user"]->getEmail() : "N/A" ?></p>
<p><b>Couleurs :</b> <?= $_SESSION["user"]->getCouleur() && !empty($_SESSION["user"]->getCouleur()) ? $_SESSION["user"]->getCouleur() : "N/A" ?></p>
<p><b>Statut :</b> <?= $_SESSION["user"]->getStatut() && !empty($_SESSION["user"]->getStatut()) ? $_SESSION["user"]->getStatut() : "N/A" ?></p>