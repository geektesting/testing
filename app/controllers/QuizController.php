<?php

namespace App\Controllers;
use App\Models\{Quizes, Questions};

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
            "quizes" => Quizes::quizList((int) $_GET["catid"]),
            "current" => $_GET["id"]
        ]);
    }

    /**
     * ActionRun
     */
    public function actionRun()
    {
        $this->render("quizes/quiz_run", [
            "quiz" => Quizes::quizInfo((int) $_GET["quizId"],"all")
        ]);
    }

    /**
     * ActionNext
     */
    public function actionRender()
    {
       echo Questions::qRender($_POST);
    }

    /**
     * ActionBuild
     */
    public function actionQuestions()
    {
        Quizes::getQuestions((int) $_POST["quizId"]);
    }
}