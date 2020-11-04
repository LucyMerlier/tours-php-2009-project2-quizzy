<?php

namespace App\Controller;

use App\Model\QuestionManager;
use App\Model\ChoiceManager;

/**
 * Class QuestionController
 * Uses QuestionManager and ChoiceManager
 * Creates index and result views that relate to the main functionality of the site :
 * seeing and answering random questions.
 */
class QuestionController extends AbstractController
{

    /**
     * Displays a random question and its possible choices.
     * @return string
     */
    public function index(): string
    {
        $errors = [];
        $questionManager = new QuestionManager();
        $question = $questionManager->selectOneRandom();
        if (empty($question)) {
            $errors[] = "Je n'ai pas trouvé de question o(╥﹏╥)o Essaies d'en ajouter une? ^_^";
        }

        if (isset($question["id"])) {
            $choices = $questionManager->selectChoices($question["id"]);
        } else {
            $choices = [];
        }

        if (empty($choices)) {
            $errors[] = "Je n'ai pas trouvé de choix valide :(";
        }

        return $this->twig->render(
            'Question/index.html.twig',
            ['question' => $question ,
            'choices' => $choices ,
            'errors' => $errors]
        );
    }

    /**
     * Displays a message that tells if the user answered the question correctly.
     * Redirects to index if $_POST['choice'] does not exist or is empty.
     * @return string
     */
    public function result(): string
    {
        $message = "";
        $choiceManager = new ChoiceManager();

        // Check if choice exists and is an int !==0
        if (isset($_POST['choice'])  && intval($_POST['choice']) !== 0) {
            $id = $_POST['choice'];
            $allChoices = $choiceManager->selectAllIds();

            // Check if choice id exists in database
            if (in_array($id, $allChoices)) {
                // Select the choice we want by id using $_POST
                $choice = $choiceManager->selectOneById($id);
                if ($choice['validity'] == 1) {
                    $message = "Gagné !";
                } else {
                    $message = "Perdu !";
                }
            }
        } else {
            // Redirection to index
            header("Location: index");
        }

        // Auto-redirection to next question after 2 seconds
        header("refresh:2;url=index");
        
        return $this->twig->render(
            'Question/result.html.twig',
            ['message' => $message]
        );
    }
}
