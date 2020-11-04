<?php

namespace App\Model;

/**
 * Class ChoiceManager
 * Is used to communicate with the choice table in the database
 */
class ChoiceManager extends AbstractManager
{
    const TABLE = 'choice';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Get all ids from choice table.
     * @return array
     */
    public function selectAllIds(): array
    {
        $result = [];
        $arrays = $this->pdo->query('SELECT id FROM ' . self::TABLE)->fetchAll();
        foreach ($arrays as $array) {
            $result[] = $array['id'];
        }
        return $result;
    }
}
