<h1>Bienvenue <?= $_SESSION["user"]->getNom() ? $_SESSION["user"]->getNom() : "" ?> !</h1>
<hr>
<p>Vous êtes connecté et pouvez à tout moment vous déconnecter avec le bouton deconnexion. Pour accèder au planning des corvées, il vous suffit d'aller sur l'onglet "Planning".</p>