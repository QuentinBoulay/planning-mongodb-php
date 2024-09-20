<?php
class userController
{
    private $userManager;
    private $user;
    private $db;

    public function __construct($db)
    {
        require('./models/User.php');
        require_once('./models/UserManager.php');
        $this->userManager = new UserManager($db);
        $this->db = $db;
    }

    public function login()
    {
        $page = 'login';
        require('./views/default.php');
    }

    public function register()
    {
        $page = 'register';
        require('./views/default.php');
    }

    public function home()
    {
        if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
            $page = 'home';
        } else {
            $page = "login";
        }
        require('./views/default.php');
    }

    public function viewAccount()
    {
        if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
            $page = 'account';
        } else {
            $page = "login";
        }
        require('./views/default.php');
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php');
        $page = 'login';
        require('./views/default.php');
    }

    public function doLogin()
    {
        try {
            $user = $this->userManager->findByEmail($_POST['email']);

            if ($user !== null) {
                if (password_verify($_POST['password'], $user->getPassword())) {
                    $result = $this->userManager->login($_POST['email'], $user->getPassword());
                } else {
                    throw new Exception("Identifiants incorrects.");
                }
            } else {
                throw new Exception("Utilisateur inconnu.");
            }
        } catch (Exception $e) {
            $_SESSION["info"] = $e->getMessage();
        }

        if (isset($result) && $result) {
            $info = "Connexion reussie";
            $_SESSION["info"] = [
                "message" => $info
            ];
            $this->user = $result;
            $_SESSION['admin'] = $this->user->getStatut() === "admin" ? true : false;
            $_SESSION['user'] = $this->user;
            $page = 'home';
        } else {
            $info = "Identifiants incorrects.";
            $_SESSION["info"] = [
                "status" => "error",
                "message" => $info
            ];
            $page = 'login';
        }

        require('./views/default.php');
    }

    public function doCreate()
    {
        if (
            isset($_POST['email']) && !empty($_POST['email']) &&
            isset($_POST['password']) && !empty($_POST['password']) &&
            isset($_POST['nom']) && !empty($_POST['nom'])
        ) {
            $alreadyExist = $this->userManager->findByEmail($_POST['email']);
            if (!$alreadyExist) {
                $newUser = new User($_POST);
                $this->userManager->create($newUser);
                $page = 'login';
                $info = "Votre compte a bien été créé. Veuillez vous connecter";
                $_SESSION["info"] = [
                    "message" => $info
                ];
            } else {
                $error = "ERROR : L'e-mail (" . $_POST['email'] . ") est déjà utilisé par un autre utilisateur.";
                $_SESSION["info"] = [
                    "status" => "error",
                    "message" => $error
                ];
                $page = 'register';
            }
        } else {
            $error = "ERROR : Certains champs sont manquants.";
            $_SESSION["info"] = [
                "status" => "error",
                "message" => $error
            ];
            $page = 'register';
        }
        require('./views/default.php');
    }

    public function usersList()
    {
        if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
            if (isset($_SESSION["admin"]) && $_SESSION["admin"]) {
                $usersList = $this->userManager->findAll();
                $page = 'usersList';
            } else {
                $page = "unauthorized";
            }
        } else {
            $page = "login";
        }

        require('./views/default.php');

    }

    public function doDelete()
    {
        if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
            if (isset($_SESSION["admin"]) && $_SESSION["admin"]) {
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $id = $_GET['id'];
                    $userExist = $this->userManager->findOne($id);
                    if ($userExist !== null) {
                        $this->userManager->delete($userExist);
                        $page = 'usersList';
                        $info = "Le compte de " . $userExist->getNom() . " à bien été supprimé !";
                        $_SESSION["info"] = [
                            "message" => $info
                        ];
                        header('Location: ?ctrl=User&action=usersList');
                    } else {
                        $error = "ERROR : L'utilisateur n'existe pas.";
                        $_SESSION["info"] = [
                            "status" => "error",
                            "message" => $error
                        ];
                        $page = 'usersList';
                        header('Location: ?ctrl=User&action=usersList');
                    }
                }
            } else {
                $page = "unauthorized";
            }
        } else {
            $page = "login";
        }
        require('./views/default.php');
    }
}