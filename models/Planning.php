<?php 

Class Planning {

    private array $dates;

    // Constructor
    public function __construct($donnees) {
        if (!empty($donnees)) {
            $this->hydrate($donnees);
        }
    }

    // Hydrate
    public function hydrate(array $donnees) {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key); // ucfirst met la première lettre en majuscule
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Set Dates
    public function setDates($dates) {
        $this->dates = $dates;
    }

    // Get Dates
    public function getDates() {
        return $this->dates;
    }
}