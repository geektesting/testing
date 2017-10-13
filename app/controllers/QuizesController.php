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
        if($this->isAuth()) {
            $this->render("quizes/quizes", [
                "quizes" => Quizes::quizList(),
                "qcats" => Qcats::catList()
            ]);
        }
        else{
            header('Location: /auth/');
        }
    }

    /**
     * ActionEdit
     */
    public function actionEdit()
    {
        if($this->isAuth()) {
            if($this->getUserRole() == 2) {
                $this->render("quizes/quizes_edit", [
                    "quiz" => Quizes::quizInfo($_GET["id"]),
                    "cats" => Cats::catList(),
                    "qcats" => Qcats::catList(),
                    "isAdmin" => 1
                ]);
            }
            else{
                $this->render("quizes/quizes_edit", [
                    "quiz" => Quizes::quizInfo($_GET["id"]),
                    "cats" => Cats::catList(),
                    "adminCats" => Cats::catList("admin"),
                    "qcats" => Qcats::catList(),
                    "isAdmin" => 0
                ]);
            }
        }
        else{
            header('Location: /auth/');
        }
    }

    /**
     * ActionCreate
     */
    public function actionCreate()
    {
        if($this->isAuth()) {
            if ($this->getUserRole() == 2) {
                $this->render("quizes/quizes_create", [
                    "cats" => Cats::catList(),
                    "qcats" => Qcats::catList(),
                    "isAdmin" => 1
                ]);
            }
            else {
                $this->render("quizes/quizes_create", [
                    "cats" => Cats::catList(),
                    "adminCats" => Cats::catList("admin"),
                    "qcats" => Qcats::catList(),
                    "isAdmin" => 0
                ]);
            }
        }
        else{
            header('Location: /auth/');
        }
    }

    /**
     * ActionSave
     */
    public function actionSave()
    {
        if($this->isAuth()) {
            Quizes::quizSave($_POST);
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
            if (Quizes::quizInfo($_GET["id"])) {
                Quizes::quizDelete($_GET["id"]);
            }
            else{
                header('Location: /quizes/');
            }
       }
        else {
            header('Location: /auth/');
        }
    }

    /**
     * ActionAdd
     */
    public function actionAdd()
    {
        if($this->isAuth()) {
            Quizes::addSelector();
        }
        else {
            header('Location: /auth/');
        }
    }
}