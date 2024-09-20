# Planning des éplucheurs

## Description
Le "Planning des éplucheurs" est une application web PHP développée pour gérer le planning et les utilisateurs d'une organisation. L'application utilise MongoDB comme base de données et permet aux utilisateurs de s'inscrire, de se connecter, de visualiser et de modifier un planning annuel.

## Fonctionnalités
- Inscription et connexion des utilisateurs
- Affichage et mise à jour du planning
- Visualisation de statistiques annuelles par utilisateur

## Configuration et déploiement
### Prérequis
- Serveur web avec PHP
- MongoDB

### Installation
1. Clonez le dépôt Git dans votre serveur web.
2. Configurez votre serveur pour pointer vers le dossier public de l'application.
4. Configurez la chaîne de connexion à MongoDB dans le fichier `models/Connection.php`.

## Utilisation
Après l'installation, l'application est accessible via un navigateur web. Les utilisateurs peuvent s'inscrire et se connecter. Une fois connecté, l'utilisateur peut visualiser et interagir avec le planning, ainsi que voir ses statistiques.

## Structure du projet
- `models/`: Contient les modèles (User, Planning, etc.).
- `views/`: Contient les fichiers de vue HTML/PHP.
- `controllers/`: Contient les contrôleurs pour la logique de l'application.
- `assets/`: Contient les fichiers CSS, JS, et autres ressources statiques.

## Fonctionalitées attendues : 
- Les éplucheurs sont répartis sur les 52 semaines de l'année. (finalisé)
- Une selection de l'année permet de faire défiler le calendrier. (finalisé)
- Les données seront stockées et gérées dans une base de données MongoDB. (finalisé)
- Vous devez finaliser vous-même la structure JSON des collections correspondantes. (finalisé)
- Les statistiques de l'année (Nb de semaines pour chaque participants, ...) seront calculées par les bonnes requêtes MongoDB (pas en PHP). (finalisé)
- L'accès à l'agenda, par un utislisateur, est conditionné par une connexion à son compte. (finalisé)


## Fonctionalitées ajoutées :
- Possibilité de s'inscrire (finalisé)
- Visualisation de son compte (finalisé)
 
