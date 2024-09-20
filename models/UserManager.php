<?php

require_once 'User.php';
require_once 'Connection.php';

class UserManager
{
    private $mongoDb;

    public function __construct(MongoDB\Driver\Manager $mongoDb)
    {
        $this->mongoDb = $mongoDb;
    }

    public function getNextSequence($name)
    {
        $command = new MongoDB\Driver\Command([
            'findAndModify' => 'counters',
            'query' => ['id' => $name],
            'update' => ['$inc' => ['seq' => 1]],
            'new' => true,
            'upsert' => true
        ]);

        $cursor = $this->mongoDb->executeCommand('Planning', $command);

        return $cursor->toArray()[0]->value->seq;
    }


    public function create(User $user): void
    {
        $bulk = new MongoDB\Driver\BulkWrite;

        $id = $this->getNextSequence('personnes');
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $couleur = '#' . dechex(rand(0x000000, 0xFFFFFF));

        $bulk->insert(['id' => $id, 'email' => $_POST['email'], 'password' => $password, 'nom' => $_POST['nom'], 'couleur' => $couleur, 'statut' => 'user']);
        $this->mongoDb->executeBulkWrite('Planning.personnes', $bulk);
    }

    public function login($email, $password): User
    {
        if ($this->findByEmail($email)) {
            $user = $this->findByEmail($email);
            return $user;
        } else {
            throw new Exception("Utilisateur introuvable.");
        }
    }


    public function update(User $user): void
    {
    }

    public function delete(User $user): void
    {
    }

    public function findByEmail($email): ?User
    {
        $filter = ['email' => $email];
        $query = new MongoDB\Driver\Query($filter);
        $cursor = $this->mongoDb->executeQuery('Planning.personnes', $query);

        $foundDocument = null;

        foreach ($cursor as $document) {
            // Convertit l'objet MongoDB en tableau pour une manipulation plus facile
            $documentArray = (array) $document;

            if (isset($documentArray['email']) && $documentArray['email'] == $email) {
                $foundDocument = $documentArray;
                break;
            }
        }

        if ($foundDocument !== null) {
            return new User($foundDocument);
        } else {
            return null;
        }
    }

    public function findOne($id): ?User
    {
        $filter = ['id' => $id];
        $query = new MongoDB\Driver\Query($filter);
        $cursor = $this->mongoDb->executeQuery('Planning.personnes', $query);

        $foundDocument = null;

        foreach ($cursor as $document) {
            // Convertit l'objet MongoDB en tableau pour une manipulation plus facile
            $documentArray = (array) $document;

            if (isset($documentArray['id']) && $documentArray['id'] == $id) {
                $foundDocument = $documentArray;
                break;
            }
        }

        if ($foundDocument !== null) {
            return new User($foundDocument);
        } else {
            return null;
        }
    }

    public function findAll(): array
    {
        $filter = [];
        $query = new MongoDB\Driver\Query($filter);
        $cursor = $this->mongoDb->executeQuery('Planning.personnes', $query);

        $users = array();

        foreach ($cursor as $document) {

            // Convertit l'objet MongoDB en tableau pour une manipulation plus facile
            $documentArray = (array) $document;



            if (isset($documentArray['id'])) {
                array_push($users, new User($documentArray));
            }
        }

        return $users;
    }
}
