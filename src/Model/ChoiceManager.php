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
}
