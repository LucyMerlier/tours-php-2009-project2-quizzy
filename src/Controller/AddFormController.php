<?php

namespace App\Controller;

use App\Model\QuestionManager;
use App\Model\ChoiceManager;

/**
 * Class AddFormController
 * Uses QuestionManager and ChoiceManager
 * Creates the different pages that allow users to add their own questions
 */
class AddFormController extends AbstractController
{
    public const QUESTION_MAX_LENGTH = 200;
    public const QUESTION_MIN_LENGTH = 3;
    public const MIN_NUMBER_OF_CHOICES = 2;
    public const MAX_NUMBER_OF_CHOICES = 6;
    public const CHOICE_MAX_LENGTH = 100;
    public const CHOICE_MIN_LENGTH = 1;
    public const MIN_NUMBER_OF_VALID_CHOICES = 1;

    /**
     * Creates the page that allows users to enter their question
     * and the number of choices they want to add
     * @return string
     */
    public function addQuestion(): string
    {
        $error = "";

        return $this->twig->render(
            'AddForm/addQuestion.html.twig',
            ['error' => $error]
        );
    }

    /**
     * Creates the page that allows users to enter their choices
     * Redirects to addQuestion with error message if there is an error
     * @return string
     */
    public function addChoices(): string
    {
        $error = "";

        // Check if userQuestion exists in $_POST
        if (!isset($_POST['userQuestion'])) {
            header("Location: ../question/index");
            return "";
        }

        // Check if numberOfChoices exists in $_POST
        if (!isset($_POST['numberOfChoices'])) {
            header("Location: ../question/index");
            return "";
        }

        $userQuestion = trim($_POST["userQuestion"]);

        // Check if question isn't too long
        if (strlen($userQuestion) > self::QUESTION_MAX_LENGTH) {
            $error = "Ta question est trop longue! Elle doit faire maximum "
            . self::QUESTION_MAX_LENGTH . " charactères.";
            return $this->twig->render(
                'AddForm/addQuestion.html.twig',
                ['error' => $error]
            );
        }

        // Check if question isn't too short
        if (strlen($userQuestion) <= self::QUESTION_MIN_LENGTH) {
            $error = "On sait que la taille fait pas tout mais ta question est trop courte!";
            return $this->twig->render(
                'AddForm/addQuestion.html.twig',
                ['error' => $error]
            );
        }

        $numberOfChoices = $_POST['numberOfChoices'];

        // Check if there are between 2 and 6 choices just in case
        if ($numberOfChoices < self::MIN_NUMBER_OF_CHOICES || $numberOfChoices > self::MAX_NUMBER_OF_CHOICES) {
            $error = "Tu dois avoir entre "
            . self::MIN_NUMBER_OF_CHOICES . " et "
            . self::MAX_NUMBER_OF_CHOICES . " choix!";
            return $this->twig->render(
                'AddForm/addQuestion.html.twig',
                ['error' => $error]
            );
        }

        // Put question and number of choices into $_SESSION
        if (!isset($_SESSION['userQuestion'])) {
            $_SESSION['userQuestion'] = $userQuestion;
        }

        if (!isset($_SESSION['numberOfChoices'])) {
            $_SESSION['numberOfChoices'] = $numberOfChoices;
        }

        return $this->twig->render(
            'AddForm/addChoices.html.twig',
            ['userQuestion' => $userQuestion ,
            'numberOfChoices' => $numberOfChoices ,
            'error' => $error]
        );
    }

    /**
     * Creates the page that allows users to select which of their choices are valid
     * @return string
     */
    public function setValidity(): string
    {
        $error = "";

        if (!isset($_SESSION['userQuestion'])) {
            header("Location: ../question/index");
            return "";
        }

        $userChoices = [];
        foreach ($_POST as $userChoice) {
            $userChoices[] = trim($userChoice);
        }

        // Check if each choice isn't too long or too short
        foreach ($userChoices as $userChoice) {
            if (strlen($userChoice) > self::CHOICE_MAX_LENGTH) {
                $error = "L'un de tes choix est trop long! Ils doivent faire maximum "
                . self::CHOICE_MAX_LENGTH . " charactères.";
                return $this->twig->render(
                    'AddForm/addChoices.html.twig',
                    ['userQuestion' => $_SESSION["userQuestion"] ,
                    'numberOfChoices' => $_SESSION["numberOfChoices"] ,
                    'error' => $error]
                );
            }

            if (strlen($userChoice) < self::CHOICE_MIN_LENGTH) {
                $error = "L'un de tes choix est trop court! Ils doivent faire minimum "
                . self::CHOICE_MIN_LENGTH . " charactère.";
                return $this->twig->render(
                    'AddForm/addChoices.html.twig',
                    ['userQuestion' => $_SESSION["userQuestion"] ,
                    'numberOfChoices' => $_SESSION["numberOfChoices"] ,
                    'error' => $error]
                );
            }
        }

        // Put choices into $_SESSION
        if (!isset($_SESSION['userChoices'])) {
            foreach ($userChoices as $userChoice) {
                $_SESSION['userChoices'][]['answer'] = $userChoice;
            }
        }

        return $this->twig->render(
            'AddForm/setValidity.html.twig',
            ['userChoices' => $_SESSION['userChoices'] ,
            'numberOfChoices' => $_SESSION['numberOfChoices'] ,
            'error' => $error]
        );
    }

    /**
     * Creates the page that tells users if their question has been added successfully
     * @return string
     */
    public function afterSubmit()
    {
        $error = "";

        if (!isset($_SESSION['userChoices'])) {
            header("Location: ../question/index");
        }

        $choicesValidity = [];
        foreach ($_POST as $choiceValidity) {
            $choicesValidity[] = $choiceValidity;
        }

        // Check if there is at least one good choice
        $numberOfValidChoices = 0;
        foreach ($choicesValidity as $choiceValidity) {
            if ($choiceValidity === "1") {
                $numberOfValidChoices++;
            }
        }

        if ($numberOfValidChoices < self::MIN_NUMBER_OF_VALID_CHOICES) {
            $error = "Il te faut au minimum " . self::MIN_NUMBER_OF_VALID_CHOICES . " bonne réponse!";
            return $this->twig->render(
                'AddForm/setValidity.html.twig',
                ['userChoices' => $_SESSION['userChoices'] ,
                'numberOfChoices' => $_SESSION['numberOfChoices'] ,
                'error' => $error]
            );
        }

        // Put validities into $_SESSION
        $increment = 0;
        foreach ($choicesValidity as $choiceValidity) {
            if (!isset($_SESSION['userChoices'][$increment]['validity'])) {
                $_SESSION['userChoices'][$increment]['validity'] = $choiceValidity;
            }
            $increment++;
        }

        $userQuestion = $_SESSION["userQuestion"];
        $userChoices = $_SESSION['userChoices'];

        $questionManager = new QuestionManager();
        $choiceManager = new ChoiceManager();

        $questionId = $questionManager->addQuestion($userQuestion);

        foreach ($userChoices as $userChoice) {
            $choiceManager->addChoice($userChoice, $questionId);
        }

        // Reset session
        unset($_SESSION["userChoices"]);
        unset($_SESSION["userQuestion"]);
        unset($_SESSION["numberOfChoices"]);

        return $this->twig->render('AddForm/afterSubmit.html.twig');
    }
}
