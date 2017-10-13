<?php
namespace App\Models;

use App\Core\DB;

/**
 * Class Qcats
 * @package models
 */
class Qcats
{

    /**
     * Возвращает массив категорий вопросов для бекенда.
     * Администратор видит все категории, пользователь - только свои.
     * @return array
     */
    static function catList() : array
    {
        $data = [];
        $user = (new User())->getCurrent();
        
        if ($user->getRole() == User::ADMINISTRATOR) {
            $data = DB::getInstance()->fetchAll("SELECT * FROM qcats");
        }
        else{
            $data = DB::getInstance()->fetchAll("SELECT * FROM qcats WHERE user_id = " . $user->getId());
        }
        return $data;
    }

    /**
     * Создаёт категорию вопросов
     * @param string $catName
     */
    function catCreate(string $catName)
    {
        $user = (new User())->getCurrent();
        DB::getInstance()->execute("INSERT INTO qcats (`cat_name`,`user_id`) VALUES ('$catName', '" . $user->getId() . "')");
        header('Location: /qcats/');
    }

    /**
     * Удаляет категорию вопросов пользователя
     * ToDo Сделать проверку категории на отсутствие в ней вопросов
     * @param int $id
     */
    function catDelete(int $id)
    {
        DB::getInstance()->execute("DELETE FROM qcats WHERE id ='$id'");
        header('Location: /qcats/');
    }

    /**
     * Переименовывает категорию
     * @param int $id
     * @param string $newName
     */
    function catRename(int $id, string $newName)
    {
            DB::getInstance()->execute("UPDATE qcats set `cat_name` = '$newName' WHERE id = '$id'");
            header('Location: /qcats/');
    }
}