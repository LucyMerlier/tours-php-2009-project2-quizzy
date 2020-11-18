<?php

namespace App\Model;

/**
 * ClassChoiceValidator
 * Is used to perform checks on the user's choices
 */
class ChoiceValidator
{
    public const CHOICE_MAX_LENGTH = 100;
    public const CHOICE_MIN_LENGTH = 1;
    public const MIN_NUMBER_OF_VALID_CHOICES = 1;

    /**
     * Choices and validity verification
     * @param array $userChoices
     * @return array
     */
    public function choicesVerifications(array $userChoices): array
    {
        $errors = [];
        $numberOfValidChoices = 0;

        // Check if each choice isn't too long or too short
        foreach ($userChoices as $userChoice) {
            if (strlen($userChoice['answer']) > self::CHOICE_MAX_LENGTH) {
                if (empty($errors[0])) {
                    $errors[0] = "L'un de tes choix est trop long! Ils doivent faire maximum "
                    . self::CHOICE_MAX_LENGTH . " caractères.";
                }
            }

            if (strlen($userChoice['answer']) < self::CHOICE_MIN_LENGTH) {
                if (empty($errors[1])) {
                    $errors[1] = "L'un de tes choix est trop court! Ils doivent faire minimum "
                    . self::CHOICE_MIN_LENGTH . " caractère.";
                }
            }

            // Count the valid choices
            if ($userChoice['validity'] === '1') {
                $numberOfValidChoices++;
            }
        }

        // Check if there is at least one good choice
        if ($numberOfValidChoices < self::MIN_NUMBER_OF_VALID_CHOICES) {
            $errors[2] = "Il te faut au minimum " . self::MIN_NUMBER_OF_VALID_CHOICES . " bonne réponse!";
        }

        return $errors;
    }
}
