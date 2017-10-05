<?php
namespace App\Models;

use App\Core\DB;

/**
 * Class SessionsRep
 * @package Rep
 */
class Cats
{
    private static $_userId = 1;  // 1 - админ
    public static $numbers = [];

    /**
     * По умолчанию возвращает массив категорий для бекенда.
     * Администратор видит все категории, пользователь - только свои.
     * С необязательным параметром "front" предназначена для отображения на фронтенде
     * всех категорий за исключением скрытых (access=private) и неодобренных(approved=0).
     * @param  string $isFront
     * @return array
     */
    static function catList(string $isFront = "") : array
    {
        $result = [];

        if ($isFront != "") {
            if ($isFront == "front") {
                $data = DB::getInstance()->fetchAll("SELECT * FROM cats WHERE approved = 1 AND access = 1");
                self::$numbers = DB::getInstance()->fetchAll("SELECT DISTINCT cat AS id, COUNT(cat) AS num FROM quizes GROUP BY cat");
            } else {
                echo "Допускается только параметр \"front\"";
                return [];
            }
        } else if (self::$_userId == 1) {
                $data = DB::getInstance()->fetchAll("SELECT * FROM cats");
        } else {
                $data = DB::getInstance()->fetchAll("(SELECT * FROM cats WHERE id = 1) 
                                                UNION (SELECT * FROM cats WHERE user_id = '" . self::$_userId . "')");
        }
        
        foreach ($data as &$item) {
            $item["ignore"] = 0;
            $item["no_delete"] = 0;
            foreach ($data as $cat) {
                if ($item["id"] == $cat["parent"]) {
                    $item["no_delete"] = 1;
                    break;
                }
            }
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

        if (self::$_userId == 1 || $isFront == "front") {
            foreach ($data as $value) {
                if (!$value["parent"]) $findChild($value);
            }
        } else {
            $findChild($data[0]);
        }

        return $result;
    }

    /**
     * Извлекает из базы информацию по конкретной категории.
     *
     * @param int $id
     * @return array
     */
    public static function catInfo(int $id) : array
    {
        return DB::getInstance()->fetchOne("SELECT * FROM cats WHERE id='$id'");
    }

    /**
     * Создаёт категорию и устанавливает для неё родительскую
     * @param string $catName
     * @param int $parent
     * @return bool
     */
    public static function catCreate(string $catName, int $parent, string $description) : bool
    {
        $description = addslashes($description);
        $data = DB::getInstance()->fetchOne("SELECT level FROM cats WHERE id = '$parent'");
        $sql = "INSERT INTO cats (`cat_name`,`description`,`parent`,`level`,`user_id`) 
                    VALUES ('$catName', '$description','$parent','$data[level]' + 1,". self::$_userId .')';
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
     * ToDo Сделать проверку категории на отсутствие в ней тестов
     * @param int $catId
     */
    public static function catDelete(int $catId)
    {
        DB::getInstance()->execute("DELETE FROM cats WHERE id ='$catId'");
        header('Location: /cats/');
    }

    /**
     * Перемещает и переименовывает категорию с детьми путём изменения её родителя.
     *
     * @param int $catId
     * @param string $newName
     * @param int $parent
     * @return bool
     */
    public static function catEdit(int $catId, string $newName, int $parent, string $description) : bool
    {
        $result = [];
		$data = [];
        $cats = self::catList();
        $description = addslashes($description);

        $where = function (int $catId = 0) : string {
            static $statement = "";
            if (!$statement) {
                $statement = "WHERE id = $catId";
                return $statement;
            }
            if ($catId) {
                $statement .= " OR id = $catId";
            }
            return $statement;
        };

        foreach ($cats as $cat) {
            if ($cat["id"] == $catId) {
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

        if (self::$_userId == 1 || $data["user_id"] == self::$_userId) { // Убрать избыточность
            DB::getInstance()->execute("UPDATE cats SET
                `cat_name` = '$newName', 
                `parent` = '$parent',
                `description` = '$description',
                `level` = '$data[level]' + 1
                WHERE id = '$catId'");
            if ($delta) {
                DB::getInstance()->execute("UPDATE cats SET `level` = `level`-'$delta'" . $where());
            }
            header('Location: /cats/');
            return true;
        }

        echo "Ошибка перемещения категории";
        return false;
    }
}
  