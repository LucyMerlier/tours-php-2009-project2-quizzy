<?php

namespace App\Model;

class QuestionManager extends AbstractManager
{
    
    const TABLE = 'question';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectOneRandom()
    {
        $statement = $this->pdo->query("SELECT * FROM $this->table ORDER BY RAND() LIMIT 1");

        return $statement->fetch();
    }

    public function selectChoices(int $id): array
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT answer , choice.id FROM $this->table JOIN choice
        WHERE question_id=:id AND question.id=:id ORDER BY choice.id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
