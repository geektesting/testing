<?php

namespace App\Controllers;
use App\Models\{Quizes, Questions, Qcats};

/**
 * Class QuestionsController
 * @package Controllers
 */
class QuestionsController extends BaseController
{ 

    /**
     * ActionIndex
     */
    public function actionIndex()
    {
		$this->render("questions/questions", [
                "questions" => Questions::qList()
            ]);
    }

    /**
     * ActionEdit
     */
    public function actionEdit()
    {
    	$this->render("questions/questions_edit", [
            "question" => Questions::qInfo($_GET["id"]),
            "qtypes" => Questions::getQtypes(),
            "qcats" => Qcats::catList()
        ]);
    }

    /**
     * ActionCreate
     */
    public function actionCreate()
    {
		$this->render("questions/questions_create", [
            "qtypes" => Questions::getQtypes(),
            "qcats" => Qcats::catList()
        ]);
    }

    /**
     * ActionSave
     */
    public function actionSave()
    {
        print_r($_POST);
        Questions::qSave($_POST);
    }

    /**
     * ActionDelete
     */
    public function actionDelete()
    { 
        Questions::qDelete($_GET["id"]);
    }

    /**
     * ActionAdd
     */
    public function actionAdd()
    {
        Questions::getAnswer($_POST["lastid"]);
    }
}