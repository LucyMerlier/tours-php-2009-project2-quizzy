<?php

namespace App\Controller;

use App\Model\ChoiceManager;
use App\Model\QuestionManager;
use App\Model\ChoiceValidator;

/**
 * Class ChoicesController
 * Uses ChoiceManager
 * Creates page that allows user to add their own choices
 * Creates page that tells the user if their question/choices have successfully been added
 */
class ChoicesController extends SessionController
{
    public const DATABASE_ERROR = -1;

    /**
     * Creates the page that allows users to enter their choices
     * @return string
     */
    public function add(): string
    {
        // Redirect to question/add if it has not been filled correctly
        if (!isset($_SESSION['userQuestion']) || !isset($_SESSION['numberOfChoices'])) {
            header('Location: ../question/add');
            return "";
        }

        $errors = [];

        if (isset($_POST['userChoices'])) {
            // Checks on userChoices
            $choiceValidator = new ChoiceValidator();
            $errors = $choiceValidator->choicesVerifications($_POST['userChoices']);

            // Display errors if there are any
            if (!empty($errors)) {
                return $this->twig->render(
                    'Choices/add.html.twig',
                    ['userQuestion' => $_SESSION['userQuestion'] ,
                    'numberOfChoices' => $_SESSION['numberOfChoices'] ,
                    'errors' => $errors]
                );
            }

            $_SESSION['userChoices'] = $_POST['userChoices'];

            // Redirect to after submit page
            header('Location: added');
            return '';
        }

        return $this->twig->render(
            'Choices/add.html.twig',
            ['userQuestion' => $_SESSION['userQuestion'] ,
            'numberOfChoices' => $_SESSION['numberOfChoices'] ,
            'errors' => $errors]
        );
    }

    /**
     * Creates the page that tells users if their question/choices have been successfully added
     * @return string
     */
    public function added(): string
    {
        // Redirect to choices/add if the forms have not been filled correctly
        if (
            !isset($_SESSION['userQuestion'])
            || !isset($_SESSION['numberOfChoices'])
            || !isset($_SESSION['userChoices'])
        ) {
            header('Location: add');
            return "";
        }

        $message = "";

        $questionManager = new QuestionManager();
        $choiceManager = new ChoiceManager();

        $questionId = $questionManager->addQuestion($_SESSION['userQuestion']);

        // Check if question has been added successfully
        if ($questionId === self::DATABASE_ERROR) {
            $message = "Une erreur est survenue :(";
            return $this->twig->render(
                'Choices/added.html.twig',
                ['message' => $message]
            );
        }

        foreach ($_SESSION['userChoices'] as $userChoice) {
            $choiceId = $choiceManager->addChoice($userChoice, $questionId);

            // Check if choice has been added successfully
            if ($choiceId === self::DATABASE_ERROR) {
                $message = "Une erreur est survenue :(";
                return $this->twig->render(
                    'Choices/added.html.twig',
                    ['message' => $message]
                );
            }
        }

        // Reset session
        unset($_SESSION["userChoices"]);
        unset($_SESSION["userQuestion"]);
        unset($_SESSION["numberOfChoices"]);

        // If database INSERT is successfull
        $message = "Ta question a bien été ajoutée !";
        return $this->twig->render(
            'Choices/added.html.twig',
            ['message' => $message]
        );
    }
}
