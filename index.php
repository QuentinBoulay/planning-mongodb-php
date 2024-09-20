<?php
ini_set('display_errors', 1);

// Inclusion du fichier de connexion à la base de données
require_once('./models/Connection.php');
$connectionBuilder = new Connection();
$db = $connectionBuilder->getDb();

// Récupération des paramètres de l'url
if (
    (isset($_GET['ctrl']) && !empty($_GET['ctrl'])) &&
    (isset($_GET['action']) && !empty($_GET['action']))
) {
    $ctrl = $_GET['ctrl'];
    $action = $_GET['action'];
} else {
    $ctrl = 'User';
    $action = 'login';
}

// Inclusion du controller
require_once('./controllers/' . $ctrl . 'Controller.php');
$ctrl = $ctrl . 'Controller';
$controller = new $ctrl($db);

// Démarrage de la session
session_start();
$_SESSION["info"] = "";

// Vérification de l'existence de la méthode et utilisation
if (method_exists($controller, $action)) {
    $controller->$action();
}



?>