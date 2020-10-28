<?php

namespace App\Controller;

use App\Model\QuestionManager;

class QuestionController extends AbstractController
{

    public function index()
    {
        $questionManager = new QuestionManager();
        $question = $questionManager->selectOneRandom();
        $choices = $questionManager->selectChoices($question["id"]);

        return $this->twig->render('Question/index.html.twig', ['question' => $question , 'choices' => $choices]);
    }
}
