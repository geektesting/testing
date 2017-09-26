<?php
namespace App\models;

use App\Core\DB;

class Qcats
{
    private static $user_id = 1;  // 1 - админ

    /**
     * Возвращает массив категорий вопросов для бекенда.
     * Администратор видит все категории, пользователь - только свои.
     * @return array
     */
    static function catList() : array
    {
        $result = [];
        if (self::$user_id == 1) {
            $result = DB::getInstance()->fetchAll("SELECT * FROM qcats");
        }
        else{
            $result = DB::getInstance()->fetchAll("SELECT * FROM qcats WHERE user_id = " . self::$user_id);
        }
        return $result;
    }

    /**
     * Создаёт категорию вопросов
     * @param string $cat_name
     * @return bool
     */
    function catCreate(string $cat_name) : bool
    {
        $sql = "INSERT INTO qcats (`cat_name`,`user_id`) VALUES ('$cat_name', '" . self::$user_id . "')";
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
    function catDelete(int $id) : void
    {
        DB::getInstance()->execute("DELETE FROM qcats WHERE id ='$id'");
        header('Location: /qcats/');
    }

    /**
     * Переименовывает категорию
     * @param int $id
     * @param string $new_name
     */
    function catRename(int $id, string $new_name) : void
    {
            DB::getInstance()->execute("UPDATE qcats set `cat_name` = '$new_name' WHERE id = '$id'");
            header('Location: /qcats/');
    }
}