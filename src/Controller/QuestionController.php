<?php

namespace App\Controller;

use App\Model\QuestionManager;

class QuestionController extends AbstractController
{

    public function index()
    {
        $questionManager = new QuestionManager();
        $question = $questionManager->selectOneById(4);
        $choices = $questionManager->selectChoices(4);

        return $this->twig->render('Question/index.html.twig', ['question' => $question , 'choices' => $choices]);
    }

}