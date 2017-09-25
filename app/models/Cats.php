<?php
namespace App\models;

use App\Core\DB;

class Cats
{
    private static $user_id = 1;  // 1 - админ

    /**
     * По умолчанию возвращает массив категорий для бекенда.
     * Администратор видит все категории, пользователь - только свои.
     * С необязательным параметром "front" предназначена для отображения на фронтенде
     * всех категорий за исключением скрытых (access=private) и неодобренных(approved=0).
     * @param $isFront string
     * @return array
     */
    static function catList(string $isFront = "") : array
    {
        $result = [];
        $data = null;

        if ($isFront != "")
            if ($isFront == "front") {
                $data = DB::getInstance()->fetchAll("SELECT * FROM cats WHERE approved = 1 AND access = 1");
            } else {
                echo "Допускается только параметр \"front\"";
                return [];
            }
        else if (self::$user_id == 1) {
            $data = DB::getInstance()->fetchAll("SELECT * FROM cats");
        } else {
            $data = DB::getInstance()->fetchAll("(SELECT * FROM cats WHERE id = 1) 
                                                union (SELECT * FROM cats WHERE user_id = '" . self::$user_id . "')");
        }

        foreach ($data as &$item) {
            $item["ignore"] = 0;
        }

        $findChild = function ($parent) use ($data, &$result, &$findChild) {
            if ($parent["parent"] == 0) {
                $result[] = $parent;
            }
            foreach ($data as &$item) {
                if ($item["parent"] == $parent["id"] && $item["ignore"] == 0) {
                    $result[] = $item;
                    $item["ignore"] = 1;
                    $findChild($item);
                }
            }
        };

        if (self::$user_id == 1 || $isFront == "front") {
            foreach ($data as $value) {
                if (!$value["parent"]) $findChild($value);
            }
        } else {
            $findChild($data[0]);
        }

        return $result;
    }

    /**
     * Создаёт категорию и устанавливает для неё родительскую
     * @param string $cat_name
     * @param int $parent
     * @return bool
     */
    function catCreate(string $cat_name, int $parent) : bool
    {
        $data = DB::getInstance()->fetchOne("SELECT level FROM cats WHERE id = '$parent'");
        $sql = "INSERT INTO cats (`cat_name`,`parent`,`level`,`user_id`) 
                    VALUES ('$cat_name', '$parent','$data[level]' + 1,'self::$user_id')";
        $result = DB::getInstance()->execute($sql);
        if ($result) {
            header('Location: /cats/');
            return true;
        } else {
            echo "Ошибка создания категории";
            return false;
        }
    }

    /**
     * Удаляет категорию пользователя
     * ToDo Сделать проверку категории на отсутствие в ней подкатегорий и тестов
     * @param int $id
     */
    function catDelete(int $id) : bool
    {
        $cats = self::catList();
        foreach ($cats as $cat) {
            if ($cat["parent"] == $id) {
                header('Location: /cats/');
                return false;
            }
        }
        DB::getInstance()->execute("DELETE FROM cats WHERE id ='$id'");
        header('Location: /cats/');
        return true;
    }

    /**
     * Перемещает и переименовывает категорию с детьми путём изменения её родителя.
     *
     * @param int $id
     * @param string $new_name
     * @param int $parent
     * @return bool
     */
    function catEdit(int $id, string $new_name, int $parent) : bool
    {
        $result = [];

        $cats = self::catList();

        $where = function (int $id = 0) : string {
            static $statement = "";
            if (!$statement) {
                $statement = "WHERE id = $id";
                return $statement;
            }
            if ($id) {
                $statement .= " OR id = $id";
            }
            return $statement;
        };

        foreach ($cats as $cat) {
            if ($cat["id"] == $id) {
                $result[] = $cat;
                while ($result[0]["level"] < next($cats)["level"]) {
                    $result[] = current($cats);
                    $where(current($cats)["id"]);
                }
                break;
            }
            next($cats);
        }

        if ($parent) {
            foreach ($cats as $cat) {
                if ($cat["id"] == $parent) {
                    $data = $cat;
                    break;
                }
            }
        } else {
            $data["level"] = -1;
        }

        $delta = $result[0]["level"] - $data["level"] - 1;

        if (self::$user_id == 1 || $data["user_id"] == self::$user_id) { // Убрать избыточность
            DB::getInstance()->execute("UPDATE cats set `cat_name` = '$new_name', `parent` = '$parent',`level` = '$data[level]' + 1 WHERE id = '$id'");
            if ($delta) {
                DB::getInstance()->execute("UPDATE cats set `level` = `level`-'$delta'" . $where());
            }
            header('Location: /cats/');
            return true;
        }

        echo "Ошибка перемещения категории";
        return false;
    }
}
  