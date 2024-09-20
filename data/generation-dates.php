<?php
function generateWeeks($startYear, $endYear) {
    $weeks = array();
    for ($year = $startYear; $year <= $endYear; $year++) {
        // Créer une date pour le premier jour de l'année
        $date = new DateTime("$year-01-01");
        // Trouver le premier lundi
        while ($date->format('N') != 1) {
            $date->add(new DateInterval('P1D'));
        }
        // Générer toutes les semaines de l'année
        while ($date->format('Y') == $year) {
            $week = array(
                "annee" => $date->format('Y'),
                "mois" => $date->format('n'),
                "jour" => $date->format('j'),
                "responsable" => ($date->format('W') % 10) + 1
            );
            array_push($weeks, $week);
            // Passer à la semaine suivante
            $date->add(new DateInterval('P7D'));
        }
    }
    return $weeks;
}

// Générer les semaines pour les années 2023, 2024 et 2025
$weeks = generateWeeks(2023, 2025);

// Convertir le tableau en JSON
$weeksJson = json_encode($weeks, JSON_PRETTY_PRINT);

// Afficher ou sauvegarder le JSON
echo $weeksJson;
?>
