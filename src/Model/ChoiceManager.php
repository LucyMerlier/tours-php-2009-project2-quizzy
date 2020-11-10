<?php

namespace App\Model;

/**
 * Class ChoiceManager
 * Is used to communicate with the choice table in the database
 */
class ChoiceManager extends AbstractManager
{
    public const TABLE = 'choice';
    public const DATABASE_ERROR = -1;

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Links choice and question id then inserts choice in DB and returns choice id
     * @param array $userChoice
     * @param int $questionId
     * @return int
     */
    public function addChoice(array $userChoice, int $questionId): int
    {
        // prepared request
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE .
            " (`answer` , `validity` , `question_id`) 
            VALUES (:answer , :validity , :question_id)"
        );
        $statement->bindValue('answer', $userChoice['answer'], \PDO::PARAM_STR);
        $statement->bindValue('validity', $userChoice['validity'], \PDO::PARAM_BOOL);
        $statement->bindValue('question_id', $questionId, \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
        return -self::DATABASE_ERROR;
    }
}
