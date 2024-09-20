<?php
class planningController
{
    private $planningManager;
    private $planning;
    private $db;

    public function __construct($db)
    {
        require('./models/User.php');
        require('./models/PlanningManager.php');
        $this->planningManager = new PlanningManager($db);
        $this->db = $db;
    }

    public function viewPlanning()
    {
        if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
            $page = 'planning';
        } else {
            $page = "login";
        }
        require('./views/default.php');
    }

    public function updatePlanning() {
        if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
            $page = 'planning';
            if (isset($_POST['annee']) && !empty($_POST['annee'])) {
                $this->planningManager->update($this->planningManager->getAllDatesByYear($_POST['annee']));
            }
        } else {
            $page = "login";
        }
        require('./views/default.php');
        
    }
}