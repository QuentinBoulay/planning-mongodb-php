<?php

require_once 'Connection.php';
require_once 'Planning.php';
require_once 'User.php';
require_once 'UserManager.php';

class PlanningManager
{
    private $mongoDb;
    private $userManager;

    public function __construct(MongoDB\Driver\Manager $mongoDb)
    {
        $this->mongoDb = $mongoDb;
        $this->userManager = new UserManager($mongoDb);

    }

    public function update($planning): void
    {
        $bulk = new MongoDB\Driver\BulkWrite;

        $responsables = $_POST['dates'];

        foreach ($responsables as $key => $value) {
            $date = explode('/', $key);

            $value = intval($value);

            $filter = ['jour' => $date[0], 'mois' => $date[1], 'annee' => $date[2]];
            $update = ['$set' => ['responsable' => $value]];
            $bulk->update($filter, $update);
        }

        $this->mongoDb->executeBulkWrite('Planning.dates', $bulk);
    }

    public function getDateResponsable($jour, $mois, $annee): ?User
    {
        $filter = ['jour' => $jour, 'mois' => $mois, 'annee' => $annee];
        $query = new MongoDB\Driver\Query($filter);
        $cursor = $this->mongoDb->executeQuery('Planning.dates', $query);

        $responsable = null;

        foreach ($cursor as $document) {
            // Convertit l'objet MongoDB en tableau
            $documentArray = (array) $document;

            if (isset($documentArray['_id']) && isset($documentArray['responsable']) && $documentArray['jour'] == $jour && $documentArray['mois'] == $mois && $documentArray['annee'] == $annee) {
                $responsable = $documentArray['responsable'];
                break;
            }
        }

        if ($responsable !== null) {
            return $this->userManager->findOne($responsable);
        } else {
            return null;
        }
    }

    public function getAllDatesByYear($annee): array
    {
        $pipeline = [
            ['$match' => ['annee' => $annee]],
            ['$lookup' => [
                'from' => 'personnes',
                'localField' => 'responsable',
                'foreignField' => 'id',
                'as' => 'responsableInfo'
            ]],
            ['$addFields' => [
                'responsableInfo' => [
                    '$cond' => [
                        'if' => ['$eq' => [['$size' => '$responsableInfo'], 0]],
                        'then' => [[]],
                        'else' => '$responsableInfo'
                    ]
                ]
            ]],
            ['$unwind' => [
                'path' => '$responsableInfo',
                'preserveNullAndEmptyArrays' => true
            ]]
        ];

        $command = new MongoDB\Driver\Command([
            'aggregate' => 'dates',
            'pipeline' => $pipeline,
            'cursor' => new stdClass,
        ]);

        $cursor = $this->mongoDb->executeCommand('Planning', $command);

        $dates = array();

        foreach ($cursor as $document) {
            $documentArray = (array) $document;
            if (isset($documentArray['_id']) && isset($documentArray['responsableInfo']) && $documentArray['annee'] == $annee) {
                array_push($dates, $documentArray);
            }
        }

        if (!empty($dates)) {
            return $dates;
        } else {
            throw new Exception("Pas de dates pour cette année");
        }
    }

    public function getStatistic($annee, $idUser): int
    {
        // Agrégation pour récupérer le nombre de fois où l'utilisateur a été responsable dans une année
        $pipeline = [
            [
                '$match' => [
                    'responsable' => $idUser,
                    'annee' => $annee
                ]
            ],
            [
                '$count' => 'nbResponsable'
            ]
        ];

        $query = new MongoDB\Driver\Command([
            'aggregate' => 'dates',
            'pipeline' => $pipeline,
            'cursor' => new stdClass()
        ]);

        $cursor = $this->mongoDb->executeCommand('Planning', $query);

        $nbResponsable = 0;

        foreach ($cursor as $document) {
            if (isset($document->nbResponsable)) {
                $nbResponsable = $document->nbResponsable;
                break;
            }
        }

        return $nbResponsable;
    }

}
