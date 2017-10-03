<?php

namespace App\Controllers;
use App\Models\{Quizes, Cats, Qcats};

/**
 * Class QuizesController
 * @package Controllers
 */
class QuizesController extends BaseController
{ 

    /**
     * ActionIndex
     */
    public function actionIndex()
    {
		$this->render("quizes/quizes", [
                "quizes" => Quizes::quizList()
            ]);
    }

    /**
     * ActionEdit
     */
    public function actionEdit()
    {
		$this->render("quizes/quizes_edit", [
            "quiz" => Quizes::quizInfo($_GET["id"]),
            "cats" => Cats::catList(),
            "qcats" => Qcats::catList()
        ]);
    }

    /**
     * ActionCreate
     */
    public function actionCreate()
    {
		$this->render("quizes/quizes_create", [
            "cats" => Cats::catList(),
            "qcats" => Qcats::catList()
        ]);
    }

    /**
     * ActionSave
     */
    public function actionSave()
    {
        print_r($_POST);
        Quizes::quizSave($_POST);
    }

    /**
     * ActionDelete
     */
    public function actionDelete()
    { 
        Quizes::quizDelete($_GET["id"]);
    }

    /**
     * ActionAdd
     */
    public function actionAdd()
    {
        Quizes::addSelector();
    }
}