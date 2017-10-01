<?php
/**
 * Created by PhpStorm.
 * User: olegbolden
 * Date: 19.09.2017
 * Time: 19:56
 */

namespace App\Controllers;
use App\Models\Qcats;

/**
 * Class QcatsController
 * @package Controllers
 */
class QcatsController extends BaseController
{
    /**
     * actionIndex
     */
    public function actionIndex()
    {
        $this->render("qcats/qcats", [
            "cats" => Qcats::catList()
        ]);
    }

    /**
     * actionEdit
     */
    public function actionEdit()
    {
        $this->render("qcats/qcats_edit", [
            "catId" => $_GET["id"],
            "catName" => $_GET["cat_name"]
        ]);
    }

    /**
     * actionRename
     */
    public function actionRename()
    {
        Qcats::catRename( (int) $_GET["id"], (string) $_GET["cat_name"]);
    }

    /**
     * actionCreate
     */
    public function actionCreate()
    {
        $this->render("qcats/qcats_create", [ ]);
    }

    /**
     * actionSave
     */
    public function actionSave()
    {
        Qcats::catCreate( (string) $_GET["cat_name"]);
    }

    /**
     * actionDelete
     */
    public function actionDelete()
    {
        Qcats::catDelete($_GET["id"]);
    }
}