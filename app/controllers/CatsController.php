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
        if($this->isAuth()) {
            $this->render("cats/cats", [
                    "cats" => Cats::catList(),
                    "role" => $this->getUserRole()
                ]);
        }
        else {
            header('Location: /auth/');
        }
    }
    
    /**
     * ActionEdit
     */
    public function actionEdit()
    {
        if($this->isAuth()) {
            if (Cats::catInfo($_GET["id"])) {
                $this->render("cats/cats_edit", [
                    "cats" => Cats::catList(),
                    "current" => $_GET["id"],
                    "role" => $this->getUserRole()
                ]);
            }
        }
        else {
            header('Location: /auth/');
        }
    }

    /**
     * ActionCreate
     */
    public function actionCreate()
    {
        if($this->isAuth()) {
            $this->render("cats/cats_create", [
                "cats" => Cats::catList(),
                "role" => $this->getUserRole()
            ]);
        }
        else {
            header('Location: /auth/');
        }
    }

    /**
     * ActionSave
     */
    public function actionSave()
    {
        if($this->isAuth()) {
            Cats::catCreate((string) $_GET["catName"], (int) $_GET["parent"],(string) $_GET["description"]);
        }
        else {
            header('Location: /auth/');
        }
    }

    /**
     * ActionDelete
     */
    public function actionDelete()
    {
        if($this->isAuth()) {
            if (Cats::catInfo($_GET["id"])) {
                Cats::catDelete($_GET["id"]);
            }
            else{
                header('Location: /cats/');
            }
        }
        else {
            header('Location: /auth/');
        }
    }

    /**
     * ActionEditSave 
     */
    public function actionEditSave()
    {
        if ($this->isAuth()) {
            Cats::catEdit((int)$_GET["catId"], (string)$_GET["catName"], (int)$_GET["parent"], (string)$_GET["description"]);
        } else {
            header('Location: /auth/');
        }
    }
}