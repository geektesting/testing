<?php
namespace App\Core;

use App\Config;
use \PDO;

class DB
{
    use Singleton;

    protected $conn;

    /**
     * @return PDO
     */
    public function getConnection()
    {
        if (is_null($this->conn)) {
            try {
                $this->conn = new PDO(
                    $this->prepareDnsString(),
                    Config::$db['DB_USER'],
                    Config::$db['DB_PASS']
                );
            } catch (\PDOException $e) {
                exit("PDO connection error!");
            }

            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $this->conn;
    }

    /**
     * @param $sql
     * @param array $params
     * @return \PDOStatement
     */
    public function query($sql, $params = [])
    {
        $smtp = $this->getConnection()->prepare($sql);
        $smtp->execute($params);
        return $smtp;
    }

    /**
     * Выборка всех записей
     * @param $sql
     * @param array $params
     * @return array
     */
    public function fetchAll($sql, $params = [])
    {
        $smtp = $this->query($sql, $params);
        return $smtp->fetchAll();
    }

    /**
     * Выборка одной записи
     * @param $sql
     * @param array $params
     * @return mixed
     */
    public function fetchOne($sql, $params = [])
    {
        return $this->fetchAll($sql, $params)[0];
    }

    /**
     * Выборка объекта
     * @param $sql
     * @param array $params
     * @param $class
     * @return mixed
     */
    public function fetchObject($sql, $params, $class)
    {
        $smtp = $this->query($sql, $params);
        $smtp->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class);
        return $smtp->fetch();
    }

    /**
     * Запросы наизменение данных
     * @param $sql
     * @param array $params
     * @return bool
     */
    public function execute($sql, $params = [])
    {
        $this->query($sql, $params);
        return true;
    }

    /**
     * @return string
     */
    protected function prepareDnsString()
    {
        return sprintf(
            "%s:host=%s;dbname=%s;charset=UTF8",
            Config::$db['DB_DRIVER'],
            Config::$db['DB_HOST'],
            Config::$db['DB_NAME']
        );
    }
}