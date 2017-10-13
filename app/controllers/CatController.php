<?php

namespace App\Controllers;
use App\Models\{
    Cats, Quizes, Cat
};

/**
 * Class CatController
 * @package Controllers
 */
class CatController extends BaseController 
{ 

    /**
     * ActionIndex
     */
    public function actionIndex()
    {
        $this->render("quizes/cat", [
            "quizes" => Quizes::quizList($_GET["id"]),
            "cats" => Cats::catList("front"),
            "current" => $_GET["id"]
        ]);
    }
}