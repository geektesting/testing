<?php
namespace App\Models\Rep;

/**
 * Class SessionsRep
 * @package Rep
 */
class SessionsRep extends AbstractRep
{

    /**
     * Очистка неиспользуемых сессий
     * @return mixed 
     */
    public function clearSessions() : mixed
    {
        return $this->db->execute(
            sprintf("DELETE FROM sessions WHERE last_update < %s", date('Y-m-d H:i:s', time() - 60 * 20))
        );
    }

    /**
     * dropSession
     * @param int $sid 
     * @return mixed 
     */
    public function dropSession(int $sid) : mixed
    {
        return $this->db->execute(
            "DELETE FROM sessions WHERE sid = ?",
            [$sid]
        );
    }

    /**
     * createNew
     * @param int $userId 
     * @param int $sid 
     * @param string $timeLast 
     * @return mixed 
     */
    public function createNew(int $userId, int $sid, string $timeLast) : mixed
    {
        return $this->db->execute(
            "INSERT INTO sessions(user_id, sid, last_update) VALUES (? ,? , ?)",
            [$userId, $sid, $timeLast]
        );
    }

    /**
     * updateLastTime
     * @param int $sid 
     * @param string $time 
     * @return mixed 
     */
    public function updateLastTime(int $sid, string $time = null) : mixed
    {
        if (is_null($time)) {
            $time = date('Y-m-d H:i:s');
        }
        return $this->db->execute(
            "UPDATE sessions SET last_update = '{$time}' WHERE sid = '{$sid}'");
    }

    /**
     * getUidBySid
     * @param int $sid 
     * @return mixed 
     */
    public function getUidBySid(int $sid) : mixed
    {
        return $this->db->fetchOne(
            "SELECT user_id FROM sessions WHERE sid = ?", [$sid]
        )['user_id'];
    }
}