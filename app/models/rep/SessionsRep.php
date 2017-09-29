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
     * @return bool
     */
    public function clearSessions() : bool
    {
        return $this->db->execute(
            "DELETE FROM sessions WHERE last_update < ?",
            [date('Y-m-d H:i:s', time() - 60 * 20)]
        );
    }

    /**
     * dropSession
     * @param string $sid
     * @return bool
     */
    public function dropSession(string $sid) : bool
    {
        return $this->db->execute(
            "DELETE FROM sessions WHERE sid = ?",
            [$sid]
        );
    }

    /**
     * createNew
     * @param int $userId 
     * @param string $sid
     * @param string $timeLast 
     * @return bool
     */
    public function createNew(int $userId, string $sid, string $timeLast) : bool
    {
        return $this->db->execute(
            "INSERT INTO sessions(user_id, sid, last_update) VALUES (? ,? , ?)",
            [$userId, $sid, $timeLast]
        );
    }

    /**
     * updateLastTime
     * @param string $sid
     * @param string $time 
     * @return bool
     */
    public function updateLastTime(string $sid, string $time = null) : bool
    {
        if (is_null($time)) {
            $time = date('Y-m-d H:i:s');
        }
        return $this->db->execute(
            "UPDATE sessions SET last_update = '{$time}' WHERE sid = '{$sid}'");
    }

    /**
     * @param string $sid
     * @return mixed
     */
    public function getUidBySid(string $sid)
    {
        return $this->db->fetchOne(
            "SELECT user_id FROM sessions WHERE sid = ?", [$sid]
        )['user_id'];
    }
}