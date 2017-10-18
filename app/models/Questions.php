<?php

namespace App\Models;
use App\Core\DB;
use App\Models\User;

/**
 * Class Questions
 */
class Questions
{

    /**
     * Возвращает список вопросов для бекенда.
     * Администратор видит все вопросы, пользователь - только свои.
     * @return array
     */
    static function qList() : array
    {
        $result = [];
        $user = (new User())->getCurrent();

        $sql = "SELECT q.id,q.user_id,q.qtype,q.description,q.answers,q.point, qcats.cat_name AS qcat_name
                      FROM questions q
                      JOIN qcats ON q.qcat = qcats.id";

        if ($user->getRole() == User::ADMINISTRATOR) {
                $result = DB::getInstance()->fetchAll($sql);
        } else {
            $result = DB::getInstance()->fetchAll($sql . " WHERE q.user_id = " . $user->getId());
        }

        foreach ($result as &$value) {
            $value["description"] = stripslashes(base64_decode($value["description"]));
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
     * Извлекает из базы информацию по конкретному вопросу.
     *
     * @param int $qId
     * @return array
     */
    public static function qInfo(int $qId) : array
    {
        $result = DB::getInstance()->fetchOne("SELECT * FROM questions WHERE id='$qId'");
        $answers = unserialize($result["answers"]);
        $result["description"] = stripslashes(base64_decode($result["description"]));
        foreach ($answers as &$value){
            $value["description"] = stripslashes(base64_decode($value["description"]));
        }
        array_pop($result);
        $result["answers"] = $answers;
        return $result;
    }

    /**
     * Выводит описание конкретного вопроса с ответами при прохождении теста,
     * а также сохраняет и анализирует ответ пользователя
     *
     * @param int $postdata
     * @return string
     */
    public static function qRender(array $postdata) : string
    {

        $checkbox = json_decode($postdata["checkbox"]);

        if ($postdata["next"]) {

            $next = self::qInfo($postdata["next"]);
            $output = nl2br($next["description"]) . "<hr>";

            if (isset($_SESSION["current"])) {
                $current = self::qInfo($_SESSION["current"]);
            }

            switch($postdata["qType"]) {
                case 0:
                        unset($_SESSION["current"]);
                        unset($_SESSION["score"]);
                        $_SESSION["current"] = $postdata["next"];
                        $_SESSION["score"] = 0;
                    break;
                case 1:
                    if ($current["answers"][$postdata["radio"]-1]["marker"]){
                        $_SESSION["score"]++;
                    }
                    break;
                case 2:

                    // Флаг правильного ответа на вопрос
                    $true = true;
                    // Метим все ответы как непроверенные
                    foreach ($current["answers"] as &$marker){
                        $marker["checked"] = 0;
                    }

                    // Проверяем правильность ответов, помеченных пользователем
                    foreach ($checkbox as $value){
                        if ($current["answers"][$value-1]["marker"]){
                            $current["answers"][$value-1]["checked"] = 1;
                        }
                        else{
                            $true = false;
                            break;
                        }
                    }

                    // Проверяем нулевые значения оставшихся ответов
                    if ($true){
                        foreach ($current["answers"] as $item){
                            if ($item["checked"] == 1){
                                continue;
                            }
                            else if ($item["marker"] == 1){
                                $true = false;
                                break;
                            }
                        }
                    }

                    // Обновляем счётчик правильных ответов
                    if ($true){
                        $_SESSION["score"]++;
                    }
            }

            $counter = 1;
            switch($next["qtype"]){
                case 1:
                    foreach($next["answers"] as $value){

                        $output .= '<div class="row answers">
                                            
                                                <div class="col-lg-1 col-md-1 order-1">
                                                    <div class="answerId">
                                                            ' . $counter . '
                                                    </div>
                                                </div>
            
                                                <div class="col-lg-1 col-md-1 order-2">
                                                    <div class="answerRadio">
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="answer" value="' . $counter++ . '">
                                                            </label>	
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-10 col-md-10 order-3">
                                                    <div class="answerDesc">
                                                            ' . $value["description"] . '
                                                    </div>
                                                </div>
                                            </div>';
                    };
                    $output .= '<input type="hidden" id="qType" value="1">';
                    break;
                case 2:
                    foreach($next["answers"] as $value){

                        $output .= '<div class="row answers">
                                            
                                                <div class="col-lg-1 col-md-1 order-1">
                                                    <div class="answerId">
                                                            ' . $counter . '
                                                    </div>
                                                </div>
            
                                                <div class="col-lg-1 col-md-1 order-2">
                                                    <div class="answerRadio">
                                                            <label class="btn btn-primary">
                                                                <input type="checkbox" name="answer[]" value="' . $counter++ . '">
                                                            </label>	
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-10 col-md-10 order-3">
                                                    <div class="answerDesc">
                                                            ' . $value["description"] . '
                                                    </div>
                                                </div>
                                            </div>';
                    };
                    $output .= '<input type="hidden" id="qType" value="2">';
                    break;
            }
                $_SESSION["current"] = $postdata["next"];
        }
        else{

            $current = self::qInfo($_SESSION["current"]);

            switch($postdata["qType"]) {
                case 1:
                    if ($current["answers"][$postdata["radio"]-1]["marker"]){
                        $_SESSION["score"]++;
                    }
                    break;

                case 2:
                    $true = true;
                    foreach ($current["answers"] as &$marker){
                        $marker["checked"] = 0;
                    }

                    foreach ($checkbox as $value){
                        if ($current["answers"][$value-1]["marker"]){
                            $current["answers"][$value-1]["checked"] = 1;
                        }
                        else{
                            $true = false;
                            break;
                        }
                    }

                    if ($true){
                        foreach ($current["answers"] as $item){
                            if ($item["checked"] == 1){
                                continue;
                            }
                            else if ($item["marker"] == 1){
                                $true = false;
                                break;
                            }
                        }
                    }

                    if ($true){
                        $_SESSION["score"]++;
                    }
            }

            $output = $_SESSION["score"];
            unset($_SESSION["current"]);
            unset($_SESSION["score"]);
        }
        return json_encode($output);
    }

    
    /**
     *  Добавляет блок вариана ответа
     * @param $id
     */
    
    public static function getAnswer(int $id, int $type = 1)
    {
        $id++;
		$output = "";

        switch ($type) {
            case 1: //Радиокнопки
                $output = <<<INC
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
INC;
				if ($id == 1){
								$output .=	'<a href="javascript:void(0)" onClick="addAnswer(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>';
				}
				else	{
								$output .=	'<a href="javascript:void(0)" onClick="removeAnswer(this)"><i class="fa fa-minus" aria-hidden="true"></i></a>';					
				}			
                $output .= <<<INC
										</div>
									</div>
								</div>
INC;
                break;

            case 2:
                echo <<<INC
        						<div class="row answers" id="r$id">
								
									<div class="col-lg-1 col-md-1 order-1">
										<div class="answerId">	$id
										</div>
									</div>

									<div class="col-lg-1 col-md-1 order-2">
										<div class="answerRadio">
												<label class="btn btn-primary">
													<input type="checkbox" name="rightAnswer[]" value="$id">
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
INC;
				if ($id == 1){
								$output .=	'<a href="javascript:void(0)" onClick="addAnswer(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>';
				}
				else	{
								$output .=	'<a href="javascript:void(0)" onClick="removeAnswer(this)"><i class="fa fa-minus" aria-hidden="true"></i></a>';					
				}			
                $output .= <<<INC
										</div>
									</div>
								</div>
INC;
        }
		echo $output;
    }

    /**
     * Сохраняет вопрос при создании или редактировании
     * ToDo подключить Ajax и реализовать проверки
     *
     * @param array $params
     */

    public static function qSave(array $params)
    {

        $user = (new User())->getCurrent();

        // Перезагружаем страницу создания вопроса, если не заполнены нужные поля
      if ( !isset($params["qCats"]) || !isset($params["rightAnswer"]) || $params["description"] == ""){
          header('Location: /questions/create/');
          return;
      }
        $qType = (int) $params["qType"];
        $answerNumber = count($params["answers"]);

		switch($qType){
			case 1:
					for ($i = 0; $i < $answerNumber; $i++){
						if ($params["rightAnswer"] == $i+1){
							$answers[$i]["marker"] = 1;
						}
						else {
							$answers[$i]["marker"] = 0;
						}
						$answers[$i]["description"] = base64_encode(addslashes($params["answers"][$i]));
					};
					break;
			case 2:
					for ($i = 0; $i < $answerNumber; $i++){
						foreach($params["rightAnswer"] as $rightAnswer){
							if ($rightAnswer == $i+1){
								$answers[$i]["marker"] = 1;
                                break;
							}
							else {
								$answers[$i]["marker"] = 0;
							}
						}
							$answers[$i]["description"] = base64_encode(addslashes($params["answers"][$i]));
					};
					break;
		}
  
		$userId = $user->getId();
        $description = base64_encode(addslashes ($params["description"]));
        $qCat = (string) $params["qCats"];
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