<?php
namespace App\Models\Rep;

class SessionsRep extends AbstractRep
{
    // Очистка неиспользуемых сессий
    public function clearSessions()
    {
        return $this->db->execute(
            sprintf("DELETE FROM sessions WHERE last_update < %s", date('Y-m-d H:i:s', time() - 60 * 20))
        );
    }

    public function dropSession($sid) {
        return $this->db->execute(
            "DELETE FROM sessions WHERE sid = ?",
            [$sid]
        );
    }

    public function createNew($userId, $sid, $timeLast)
    {
        return $this->db->execute(
            "INSERT INTO sessions(user_id, sid, last_update) VALUES (? ,? , ?)",
            [$userId, $sid, $timeLast]
        );
    }

    public function updateLastTime($sid, $time = null)
    {
        if (is_null($time)) {
            $time = date('Y-m-d H:i:s');
        }
        return $this->db->execute(
            "UPDATE sessions SET last_update = '{$time}' WHERE sid = '{$sid}'");
    }

    public function getUidBySid($sid)
    {
        return $this->db->fetchOne(
            "SELECT user_id FROM sessions WHERE sid = ?", [$sid]
        )['user_id'];
    }
}