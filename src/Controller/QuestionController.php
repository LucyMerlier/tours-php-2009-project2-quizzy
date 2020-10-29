<?php

namespace App\Controller;

use App\Model\QuestionManager;

class QuestionController extends AbstractController
{

    /**
     * Displays a random question and its possible choices.
     * @return string
     */
    public function index(): string
    {
        $questionManager = new QuestionManager();
        $question = $questionManager->selectOneRandom();
        $choices = $questionManager->selectChoices($question["id"]);

        return $this->twig->render('Question/index.html.twig', ['question' => $question , 'choices' => $choices]);
    }
}
