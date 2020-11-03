<?php

namespace App\Model;

/**
 * Class QuestionManager
 * Is used to communicate with the question table in the database
 */
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

    /**
     * Selects a random question.
     * If table is empty or does not exist or if we encounter an error, returns an error message.
     * @return array
     */
    public function selectOneRandom(): array
    {
        try {
            $statement = $this->pdo->query("SELECT * FROM " . self::TABLE . " ORDER BY RAND() LIMIT 1");
        } catch (\Exception $e) {
            return [];
        }

        if ($statement === false) {
            return [];
        }

        $result = $statement->fetch();

        if ($result === false) {
            return [];
        }
        return $result;
    }

    /**
     * Selects all the choices linked to a random question.
     * If table is empty or does not exist or if $id === 0 or if we encounter an error, returns an empty array.
     * @param int $id
     * @return array
     */
    public function selectChoices(int $id): array
    {

        if ($id <= 0) {
            return [];
        }

        try {
            // prepared request
            $statement = $this->pdo->prepare("SELECT answer , choice.id , choice.validity FROM $this->table JOIN choice
            WHERE question_id=:id AND question.id=:id ORDER BY choice.id");
            $statement->bindValue('id', $id, \PDO::PARAM_INT);
            $statement->execute();
        } catch (\Exception $e) {
            return [];
        }

        if ($statement->bindValue('id', $id, \PDO::PARAM_INT) === false) {
            return [];
        }

        if ($statement->execute() === false) {
            return [];
        }

        $result = $statement->fetchAll();

        if ($result === false) {
            return [];
        }

        return $result;
    }
}
