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
            "quizes" => Quizes::quizList($_GET["catid"]),
            "current" => $_GET["id"]
        ]);
    }
}