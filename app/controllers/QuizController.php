<?php

namespace App\Controllers;
use App\Models\Quizes;

/**
 * Class QuizController
 * @package Controllers
 */
class QuizController extends BaseController
{ 

    /**
     * ActionIndex
     */
    public function actionIndex()
    {
		$this->render("quizes/quiz", [
                "quiz" => Quizes::quizInfo($_GET["id"])
            ]);
    }
}