<?php

namespace App\Controller;

use App\Model\QuestionManager;
use App\Model\ChoiceManager;

/**
 * Class AddFormController
 * Uses QuestionManager and ChoiceManager
 * Creates
 */
class AddFormController extends AbstractController
{
    public function addQuestion(): string
    {
        return $this->twig->render('AddForm/addQuestion.html.twig');
    }

    public function addChoices(): string
    {
        if (!isset($_POST['userQuestion'])) {
            header("Location: ../question/index");
        }
        $userQuestion = $_POST["userQuestion"];
        $numberOfChoices = $_POST['numberOfChoices'];
        $_SESSION['userQuestion'] = $_POST['userQuestion'];
        $_SESSION['numberOfChoices'] = $_POST['numberOfChoices'];

        return $this->twig->render(
            'AddForm/addChoices.html.twig',
            ['userQuestion' => $userQuestion ,
            'numberOfChoices' => $numberOfChoices]
        );
    }

    public function setValidity(): string
    {
        if (!isset($_SESSION['userQuestion'])) {
            header("Location: ../question/index");
        }

        $numberOfChoices = $_SESSION['numberOfChoices'];
        foreach ($_POST as $userChoice) {
            $_SESSION['userChoices'][]['answer'] = $userChoice;
        }

        $userChoices = $_SESSION['userChoices'];

        return $this->twig->render(
            'AddForm/setValidity.html.twig',
            ['userChoices' => $userChoices ,
            'numberOfChoices' => $numberOfChoices]
        );
    }

    public function afterSubmit()
    {
        if (!isset($_SESSION['userChoices'])) {
            header("Location: ../question/index");
        }

        $increment = 0;
        foreach ($_POST as $choiceValidity) {
            $_SESSION['userChoices'][$increment]['validity'] = $choiceValidity;
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

        session_unset();

        return $this->twig->render('AddForm/afterSubmit.html.twig');
    }
}
