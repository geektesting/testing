<?php

namespace App\Models;
use App\Core\DB;

/**
 * Class Quizes
 */
class Quizes
{
    private static $_userId = 1;  // 1 - админ

    /**
     * По умолчанию возвращает список тестов для бекенда.
     * Администратор видит все тесты, пользователь - только свои.
     * С необязательным параметром "front" предназначена для отображения
     * на фронтенде всех доступных данному пользователю тестов.
     * @param  string $isFront
     * @return array
     */
    static function quizList(string $isFront = "") : array
    {
        $result = [];
        $sql = "SELECT q.id, q.user_id, q.name, q.status, q.hidden, cats.cat_name AS cat_name 
                                   FROM quizes q
                                   LEFT JOIN cats ON q.cat = cats.id";

        if ($isFront != "") {
            if ($isFront == "front") {
                $result = DB::getInstance()->fetchAll($sql);
            } else {
                echo "Допускается только параметр \"front\"";
                return [];
            }
        } else if (self::$_userId == 1) {
                $result = DB::getInstance()->fetchAll($sql);
        } else {
                $result = DB::getInstance()->fetchAll($sql . " WHERE q.user_id = " . self::$_userId);
        }

        return $result;
    }

    /**
     * Извлекает из базы информацию по конкретному тесту.
     *
     * @param int $quizId
     * @return array
     */
    public static function quizInfo(int $quizId) : array
    {
        $result = DB::getInstance()->fetchOne("SELECT * FROM quizes WHERE id='$quizId'");
        $settings = unserialize($result["settings"]);
        array_pop($result);
        return array_merge($result, $settings);
    }

    
    /**
     *  Добавляет блок полей выбора категории вопросов и их количества
     */
    
    public static function addSelector()
    {
        $qCats = Qcats::catList();
        $output = <<<INC
								<div class="row">
								
									<div class="col-lg-6 col-md-6 order-1">
										<div class="form-group">
											<select class="form-control" name="qCats[]">
													<option value="" selected disabled></option>\n
INC;
        
        foreach ($qCats as $cat){
            $output .= "<option value=\"" . $cat["id"] . "\">" . $cat["cat_name"] . "</option>\n";
        }
        
        $output .= <<<INC
											</select>
										</div>
									</div>

									<div class="col-lg-6 col-md-6 order-2">
										<div class="qNumber">
											<div class="form-group">
												<input type="text" class="form-control" name="qNumber[]" value="10">
											</div>
										</div>
										<div class="plus-minus">
											<a href="javascript:void()" onClick="removeSelector(this)"><i class="fa fa-minus" aria-hidden="true"></i></a>
										</div>
									</div>
								</div>
INC;
    echo $output;
    }

    
    /**
     * Сохраняет тест при создании или редактировании
     * ToDo подключить Ajax и реализовать проверки
     *
     * @param array $params
     */

    public static function quizSave(array $params)
    {

        // Перезагружаем страницу создания теста, если не заполнены нужные поля
        if ( $params["quizName"] == 0 || !isset($params["catName"]) || !isset($params["qCats"])){
            header('Location: /quizes/create/');
            return;
        }

        // Создаём URL для скрытого теста с токеном из 10 Hex-символов
        if (isset ($params["quizId"])) {
            if ($params["hidden"] == 1) {
                if ($params["token"]) {
                    $newToken = $params["token"];
                } else {
                    $newToken = md5(rand(1, 9999) . microtime());
                }
            } else {
                $newToken = NULL;
            }
        }
        else {
            if ($params["hidden"] == 1){
                $newToken = md5(rand(1,9999).microtime());
            }
            else {
                $newToken = NULL;
            }
        }

        $catNumber = count($params["qCats"]);

        for ($i = 0; $i < $catNumber; $i++){
            $questions[$params["qCats"][$i]] = $params["qNumber"][$i];
        }

        $userId = self::$_userId;
        $quizName = (string) $params["quizName"];
        $description = (string) $params["description"];
        $catName = (string) $params["catName"];
        $status = (int) $params["status"];
        $isRandom = (int) $params["isRandom"];
        $passScore = (float) $params["passScore"];
        $time = (int) $params["time"];
        $timeGap = (int) $params["timeGap"];

            $_settings["isRandom"] = $isRandom;
            $_settings["passScore"] = $passScore;
            $_settings["time"] = $time;
            $_settings["timeGap"] = $timeGap;
            $_settings["questions"] = $questions;

        $settings = serialize($_settings);

        if (isset ($params["quizId"])){
            $sql = "UPDATE quizes
                          SET `user_id` = '$userId',
                                  `name` = '$quizName',
                                  `description` = '$description',
                                  `cat` = '$catName',
                                  `status` = '$status',
                                  `hidden` = '$newToken',
                                  `settings` = '$settings'
                          WHERE id = '$params[quizId]'";
        }
        else{
            $sql = "INSERT INTO quizes (`user_id`,`name`,`description`,`cat`,`status`,`hidden`,`settings`) 
                        VALUES ('$userId', '$quizName','$description','$catName','$status','$newToken','$settings')";
        }
        $result = DB::getInstance()->execute($sql);
        header('Location: /quizes/');
    }

    
    /**
     * Удаляет тест
     * @param int $quizId
     */
    public static function quizDelete(int $quizId)
    {
        DB::getInstance()->execute("DELETE FROM quizes WHERE id ='$quizId'");
        header('Location: /quizes/');
    }
}
  