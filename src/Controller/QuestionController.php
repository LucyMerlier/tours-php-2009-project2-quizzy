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
class QuestionController extends SessionController
{
    public const QUESTION_MAX_LENGTH = 200;
    public const QUESTION_MIN_LENGTH = 3;
    public const MIN_NUMBER_OF_CHOICES = 2;
    public const MAX_NUMBER_OF_CHOICES = 6;

    /**
     * Displays a random question and its possible choices.
     * @return string
     */
    public function index(): string
    {
        $errors = [];
        $questionManager = new QuestionManager();
        $question = $questionManager->selectOneRandom();

        // Check if there is a question to display
        if (empty($question)) {
            $errors[] = "Je n'ai pas trouvé de question o(╥﹏╥)o Essaie d'en ajouter une? ^_^";
        }

        if (isset($question["id"])) {
            $choices = $questionManager->selectChoices($question["id"]);
        } else {
            $choices = [];
        }

        // Check if there are choices to display
        if (empty($choices) && !isset($errors[0])) {
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

        /**
         * Check if id is an int and > 0 and displays an error message if id not found in choice table.
         * The try/catch catches the exception produced when you try to access a "validity" field that does not exist,
         * so it checks if the id exists in the choice table AND if it has a "validity" field at once.
         * (because you can not access the "validity" field of a line that does not exist)
         */
        try {
            $id = filter_input(INPUT_POST, 'choice', FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
            if ($id !== false && $id !== null) {
                $choice = $choiceManager->selectOneById($id);
                if ($choice['validity'] == 1) {
                    $message = "Gagné !";
                } else {
                    $message = "Perdu !";
                }
            } else {
                // Redirection to index
                header("Location: index");
                return "";
            }
        } catch (\Exception $e) {
            $message = "Une erreur est survenue :(";
        }

        // Auto-redirection to next question after 2 seconds
        header("refresh:2;url=index");

        return $this->twig->render(
            'Question/result.html.twig',
            ['message' => $message]
        );
    }

    /**
     * Creates the page that allows users to enter their question
     * and the number of choices they want to add
     * @return string
     */
    public function add(): string
    {
        $error = "";

        // Check if userQuestion and numberOfChoices exist in $_POST
        if (isset($_POST['userQuestion']) && isset($_POST['numberOfChoices'])) {
            $userQuestion = trim($_POST["userQuestion"]);

            // Check if question isn't too long
            if (strlen($userQuestion) > self::QUESTION_MAX_LENGTH) {
                $error = "Ta question est trop longue! Elle doit faire maximum "
                . self::QUESTION_MAX_LENGTH . " caractères.";
                return $this->twig->render(
                    'Question/add.html.twig',
                    ['error' => $error]
                );
            }

            // Check if question isn't too short
            if (strlen($userQuestion) <= self::QUESTION_MIN_LENGTH) {
                $error = "On sait que la taille fait pas tout mais ta question est trop courte!";
                return $this->twig->render(
                    'Question/add.html.twig',
                    ['error' => $error]
                );
            }

            $numberOfChoices = filter_input(
                INPUT_POST,
                'numberOfChoices',
                FILTER_VALIDATE_INT,
                ["options" => [
                    "min_range" => self::MIN_NUMBER_OF_CHOICES,
                    "max_range" => self::MAX_NUMBER_OF_CHOICES]
                ]
            );

            // Check if number of questions is a valid number
            if ($numberOfChoices === false || $numberOfChoices === null) {
                $error = "Tu dois avoir entre "
                . self::MIN_NUMBER_OF_CHOICES . " et "
                . self::MAX_NUMBER_OF_CHOICES . " choix!";

                return $this->twig->render(
                    'Question/add.html.twig',
                    ['error' => $error]
                );
            }

            // Put question and number of choices into $_SESSION
            $_SESSION['userQuestion'] = $userQuestion;
            $_SESSION['numberOfChoices'] = $numberOfChoices;

            // Redirect to page to add choices
            header('Location: ../choices/add');
            return '';
        }

        return $this->twig->render(
            'Question/add.html.twig',
            ['error' => $error]
        );
    }
}
