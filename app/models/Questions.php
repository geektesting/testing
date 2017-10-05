<?php

namespace App\Models;
use App\Core\DB;

/**
 * Class Questions
 */
class Questions
{
    private static $_userId = 1;  // 1 - админ

    /**
     * Возвращает список вопросов для бекенда.
     * Администратор видит все вопросы, пользователь - только свои.
     * @return array
     */
    static function qList() : array
    {
        $result = [];
        $sql = "SELECT q.id,q.user_id,q.qtype,q.description,q.answers,q.point, qcats.cat_name AS qcat_name
                      FROM questions q
                      LEFT JOIN qcats ON q.qcat = qcats.id";

        if (self::$_userId == 1) {
                $result = DB::getInstance()->fetchAll($sql);
        } else {
            $result = DB::getInstance()->fetchAll($sql . " WHERE q.user_id = " . self::$_userId);
        }

        return $result;
    }

    /**
     *  Возвращает список типов вопросов
     * @return array
     */
    public static function getQtypes() : array {
        return DB::getInstance()->fetchAll("SELECT * FROM qtypes");
    }

    /**
     * Извлекает из базы информацию по конкретному тесту.
     *
     * @param int $qId
     * @return array
     */
    public static function qInfo(int $qId) : array
    {
        $result = DB::getInstance()->fetchOne("SELECT * FROM questions WHERE id='$qId'");
        $answers = unserialize($result["answers"]);
        array_pop($result);
        $result["answers"] = $answers;
        return $result;
    }

    
    /**
     *  Добавляет блок вариана ответа
     * @param $id
     */
    
    public static function getAnswer(string $id)
    {
        $id++;
        echo  <<<INC
        						<div class="row answers" id="r$id">
								
									<div class="col-lg-1 col-md-1 order-1">
										<div class="answerId">	$id
										</div>
									</div>

									<div class="col-lg-1 col-md-1 order-2">
										<div class="answerRadio">
												<label class="btn btn-primary">
													<input type="radio" name="rightAnswer" value="$id">
												</label>	
										</div>
									</div>
									
									<div class="col-lg-10 col-md-10 order-3">
										<div class="answerDesc">
											<div class="form-group">
												<textarea class="form-control" name="answers[]" rows="2" value=""></textarea>
											</div>
										</div>
										<div class="answerToggle">
											<a href="javascript:void(0)" onClick="removeAnswer(this)"><i class="fa fa-minus" aria-hidden="true"></i></a>
										</div>
									</div>
								</div>
INC;
    }

    /**
     * Сохраняет тест при создании или редактировании
     * ToDo подключить Ajax и реализовать проверки
     *
     * @param array $params
     */

    public static function qSave(array $params)
    {

        // Перезагружаем страницу создания теста, если не заполнены нужные поля
      if ( !isset($params["qCats"]) || !isset($params["rightAnswer"]) || $params["description"] == ""){
          header('Location: /questions/create/');
          return;
      }

        $answerNumber = count($params["answers"]);

        for ($i = 0; $i < $answerNumber; $i++){
            if ($params["rightAnswer"] == $i+1){
                $answers[$i]["marker"] = 1;
            }
            else {
                $answers[$i]["marker"] = 0;
            }
            $answers[$i]["description"] = $params["answers"][$i];
        }

        $userId = self::$_userId;
        $description = addslashes ($params["description"]);
        $qCat = (string) $params["qCats"];
        $qType = (int) $params["qType"];
        $point = (float) $params["point"];
        $answers = serialize($answers);

        if (isset ($params["qId"])){
            $sql = "UPDATE questions
                          SET `user_id` = '$userId',
                                  `qcat` = '$qCat',
                                  `qtype` = '$qType',
                                  `description` = '$description',
                                  `answers` = '$answers',
                                  `point` = '$point'
                          WHERE id = '$params[qId]'";
        }
        else{
            $sql = "INSERT INTO `questions` (`user_id`,`qcat`,`qtype`,`description`,`answers`,`point`) 
                        VALUES ('$userId', '$qCat','$qType','$description','$answers','$point')";
        }
        $result = DB::getInstance()->execute($sql);
        header('Location: /questions/');
    }

    
    /**
     * Удаляет вопрос
     * @param int $qId
     */
    public static function qDelete(int $qId)
    {
        DB::getInstance()->execute("DELETE FROM questions WHERE id ='$qId'");
        header('Location: /questions/');
    }
}