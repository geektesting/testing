<?php
/**
 * Created by PhpStorm.
 * User: olegbolden
 * Date: 19.09.2017
 * Time: 19:56
 */

namespace App\Controllers;
use App\Models\Cats;

/**
 * Class CatsController
 * @package Controllers
 */
class CatsController extends BaseController 
{ 

    /**
     * ActionIndex
     */
    public function actionIndex()
    {
		$this->render("cats/cats", [
                "cats" => Cats::catList()
            ]);
    }
    
    /**
     * ActionEdit
     */
    public function actionEdit()
    {
		$this->render("cats/cats_edit", [
            "cats" => Cats::catList(),
            "current" => $_GET["id"]
        ]);
    }

    /**
     * ActionCreate
     */
    public function actionCreate()
    {
		$this->render("cats/cats_create", [
            "cats" => Cats::catList()
        ]);
    }

    /**
     * ActionSave
     */
    public function actionSave()
    {
        Cats::catCreate((string) $_GET["catName"], (int) $_GET["parent"],(string) $_GET["description"]);
    }

    /**
     * ActionDelete
     */
    public function actionDelete()
    { 
        Cats::catDelete($_GET["id"]);
    }

    /**
     * ActionEditSave 
     */
    public function actionEditSave()
    {
        Cats::catEdit((int) $_GET["catId"], (string) $_GET["catName"], (int) $_GET["parent"],(string) $_GET["description"]);
    }
}