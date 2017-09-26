<?php
namespace App\Core;

use App\Config;
use \PDO;

/**
 * Class DB
 * @package Core
 */
class DB
{
    use Singleton;

    protected $conn;

    /**
     * GetConnection
     * @return PDO
     */
    public function getConnection() : PDO
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
     * Query
     * @param string $sql
     * @return \PDOStatement 
     */
    public function query(string $sql)
    {
        return $this->getConnection()->prepare($sql);
    }

    /**
     * Выборка всех записей
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function fetchAll(string $sql, array $params = []) : array
    {
        $smtp = $this->query($sql);
        $smtp->execute($params);
        return $smtp->fetchAll();
    }

    /**
     * Выборка одной записи
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function fetchOne($sql, $params = [])
    {
        $smtp = $this->query($sql);
        $smtp->execute($params);
        return $this->fetchAll()[0];
    }

    /**
     * Выборка объекта
     * @param string $sql
     * @param array $params
     * @param mixed $class
     * @return mixed
     */
    public function fetchObject(string $sql, array $params, mixed $class) : mixed
    {
        $smtp = $this->query($sql);
        $smtp->execute($params);
        $smtp->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class);
        return $smtp->fetch();
    }

    /**
     * Запросы наизменение данных
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function execute(string $sql, array $params = []) : bool
    {
        $smtp = $this->query($sql);
        $smtp->execute($params);
        return true;
    }

    /**
     * PrepareDnsString
     * @return string
     */
    protected function prepareDnsString() : string
    {
        return sprintf(
            "%s:host=%s;dbname=%s;charset=UTF8",
            Config::$db['DB_DRIVER'],
            Config::$db['DB_HOST'],
            Config::$db['DB_NAME']
        );
    }
}