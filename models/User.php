<?php

class User
{
    private int $id;
    private string $email;
    private string $password;
    private string $nom;
    private string $statut;
    private string $couleur;

    // Constructor
    public function __construct(array $donnes)
    {
        if (!empty($donnes)) {
            $this->hydrate($donnes);
        }
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key); // ucfirst met la première lettre en majuscule
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Set the User ID
    public function setId($id)
    {
        $this->id = $id;
    }

    // Get the User ID
    public function getId()
    {
        return $this->id;
    }

    // Set the email
    public function setEmail($email)
    {
        $this->email = $email;
    }

    // Get the email
    public function getEmail()
    {
        return $this->email;
    }

    // Set the first name
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    // Get the first name
    public function getNom()
    {
        return $this->nom;
    }

    // Set admin status
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    // Get admin status
    public function getStatut()
    {
        return $this->statut;
    }

    // Set password
    public function setPassword($password)
    {
        $this->password = $password;
    }

    // Get password
    public function getPassword()
    {
        return $this->password;
    }

    // Set couleur
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;
    }

    // Get couleur
    public function getCouleur()
    {
        return $this->couleur;
    }
}
