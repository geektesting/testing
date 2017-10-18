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
             "questions" => Questions::qList(),
             "qcats" => Qcats::catList()
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
        Questions::getAnswer($_POST["lastid"],$_POST["type"]);
    }
	
	 /**
     * ActionToggle
     */
    public function actionToggle()
    {
        Questions::getAnswer(0, $_POST["type"]);
    }
	
}