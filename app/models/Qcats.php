<?php
namespace App\Models;

use App\Core\DB;

/**
 * Class Qcats
 * @package models
 */
class Qcats
{
    private static $_userId = 1;  // 1 - админ

    /**
     * Возвращает массив категорий вопросов для бекенда.
     * Администратор видит все категории, пользователь - только свои.
     * @return array
     */
    static function catList() : array
    {
        $result = [];
        if (self::$_userId == 1) {
            $result = DB::getInstance()->fetchAll("SELECT * FROM qcats");
        }
        else{
            $result = DB::getInstance()->fetchAll("SELECT * FROM qcats WHERE user_id = " . self::$_userId);
        }
        return $result;
    }

    /**
     * Создаёт категорию вопросов
     * @param string $catName
     * @return bool
     */
    function catCreate(string $catName) : bool
    {
        $sql = "INSERT INTO qcats (`cat_name`,`user_id`) VALUES ('$catName', '" . self::$_userId . "')";
        $result = DB::getInstance()->execute($sql);
        if ($result) {
            header('Location: /qcats/');
            return true;
        } else {
            echo "Ошибка создания категории";
            return false;
        }
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