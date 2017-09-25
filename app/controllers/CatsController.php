<?php
/**
 * Created by PhpStorm.
 * User: olegbolden
 * Date: 19.09.2017
 * Time: 19:56
 */

namespace App\controllers;
use App\models\Cats;

class CatsController extends BaseController {
	
    public function actionIndex() :void
    {
            echo $this->render("cats", [
                "cats" => Cats::catList()
            ]);
    }

    public function actionEdit() :void
    {
        echo $this->render("cats_edit", [
            "cats" => Cats::catList(),
            "current" => $_GET["id"]
        ]);
    }

    public function actionCreate() :void
    {
        echo $this->render("cats_create", [
            "cats" => Cats::catList()
        ]);
    }

    public function actionSave() :void
    {
        Cats::catCreate( (string) $_GET["catName"], (int) $_GET["parent"]);
    }

    public function actionDelete() :void
    {
        Cats::catDelete($_GET["id"]);
    }

    public function actionEditsave() :void
    {
        Cats::catEdit((int) $_GET["catId"], (string) $_GET["catName"], (int) $_GET["parent"]);
    }
}