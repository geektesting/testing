<?php
/**
 * Created by PhpStorm.
 * User: olegbolden
 * Date: 19.09.2017
 * Time: 19:56
 */

namespace App\controllers;
use App\models\Qcats;

class QcatsController extends BaseController {
	
    public function actionIndex() :void
    {
            echo $this->render("qcats", [
                "cats" => Qcats::catList()
            ]);
    }

    public function actionEdit() :void
    {
        echo $this->render("qcats_edit", [
            "catId" => $_GET["id"],
            "catName" => $_GET["cat_name"]
        ]);
    }

    public function actionRename() :void
    {
        Qcats::catRename( (int) $_GET["id"], (string) $_GET["cat_name"]);
    }

    public function actionCreate() :void
    {
        echo $this->render("qcats_create", [ ]);
    }

    public function actionSave() :void
    {
        Qcats::catCreate( (string) $_GET["cat_name"]);
    }

    public function actionDelete() :void
    {
        Qcats::catDelete($_GET["id"]);
    }
}