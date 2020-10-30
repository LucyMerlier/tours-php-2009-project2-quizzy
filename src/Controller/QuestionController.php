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
        $error = "";
        $questionManager = new QuestionManager();
        $question = $questionManager->selectOneRandom();
        if (empty($question)) {
            $error = "Je n'ai pas trouvé de question o(╥﹏╥)o Essaies d'en ajouter une? ^_^";
        }

        if (isset($question["id"])) {
            $choices = $questionManager->selectChoices($question["id"]);
        } else {
            $choices = [];
        }


        return $this->twig->render(
            'Question/index.html.twig',
            ['question' => $question ,
            'choices' => $choices ,
            'error' => $error]
        );
    }
}
