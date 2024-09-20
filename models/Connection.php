<?php
class Connection
{
    private object $db;
    public function __construct()
    {
        try {
            // Connexion à MongoDB Atlas
            $this->db = new MongoDB\Driver\Manager("mongodb+srv://quentseb:quentseb@cluster0.fut6sbu.mongodb.net/");
        } 
        catch (MongoDB\Driver\Exception\Exception $e) {
            echo "Probleme! : ".$e->getMessage();
            exit();
        }
    }
    public function getDb(): object
    {
        return $this->db;
    }
}