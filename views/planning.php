<h1>Planning</h1>

<?php
require_once "models/PlanningManager.php";
require_once "models/UserManager.php";
require_once "models/Connection.php";
require_once "models/UserManager.php";

$connection = new Connection();
$planningManager = new PlanningManager($connection->getDb());
$userManager = new UserManager($connection->getDb());

$annee = isset($_POST['annee']) ? $_POST['annee'] : date('Y');
$dates = $planningManager->getAllDatesByYear($annee);

// Création de la liste des users
$users = $userManager->findAll();
$user_list = "";
foreach ($users as $user) {
    $user_list .= '<option style="--color:' . $user->getCouleur() . '"value="' . $user->getId() . '">' . $user->getNom() . '</option>';
}
?>

<form action="?ctrl=Planning&action=viewPlanning" method="POST" id="form-year">
    <select id="annee-select" name="annee">
        <?php
        $annes_dispo = ['2023', '2024', '2025'];

        if ($annee) {
            echo '<option>' . $annee . '</option>';
        } 

        foreach ($annes_dispo as $key => $value) {
            if ($value == $annee) {
                continue;
            } else {
                echo '<option>' . $value . '</option>';
            }
        }
        ?>
        <input type="submit" value="Changer l'année">
    </select>
</form>

<form action="?ctrl=Planning&action=updatePlanning" method="POST" id="form-dates">
    <input type="hidden" name="annee" value="<?= $annee ?>">
    <table id="planning">
        <?php
        $count = 0;
        foreach ($dates as $date) {
            if ($count % 4 == 0) {
                echo '<tr>'; // Début d'une nouvelle ligne toutes les 4 dates
            }

            $color = "";
            $selectName = $date['jour'] . '/' . $date['mois'] . '/' . $date['annee'];

            if ($date["responsableInfo"]) {
                $color = "style='--color: " . $date["responsableInfo"]->couleur . ";'";
            }

            $jour_affichage = $date['jour'] < 10 ? '0' . $date['jour'] : $date['jour'];
            $mois_affichage = $date['mois'] < 10 ? '0' . $date['mois'] : $date['mois'];

            echo '<td>' . $jour_affichage . '/' . $mois_affichage . '/' . $date['annee'] . '<select name="dates['. $selectName .']" ' . $color . '>';
                if ($date["responsableInfo"]) {
                    echo '<option value="' . $date["responsableInfo"]->id . '">' . $date["responsableInfo"]->nom . '</option>';
                    echo '<option value="0">-- Sélectionner une personnes --</option>';
                } else {
                    echo '<option value="0">-- Sélectionner une personnes --</option>';
                }

                // Affichage de la liste des users
                echo $user_list;

            echo '</select></td>';

            if ($count % 4 == 3) {
                echo '</tr>'; // Fin de la ligne après 4 dates
            }
            $count++;
        }

        if ($count % 4 != 0) {
            echo '</tr>';
        }
        ?>
    </table>
    <input type="submit" value="Modifier les responsables">
</form>

<section id="statistics">
    <h2>Statistiques</h2>
    <?php foreach ($userManager->findAll() as $user) { ?>
        <p>
            <?= $user->getNom() ?> :
            <?= $planningManager->getStatistic($annee, $user->getId()) ?>
        </p>
    <?php } ?>
</section>