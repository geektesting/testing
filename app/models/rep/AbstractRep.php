<?php

namespace App\Models\Rep;

use App\Core\DB;

abstract class AbstractRep {
    /**
     * @var DB
     */
    protected $db;

    /**
     * AbstractRep constructor.
     */
    public function __construct() {
        $this->db = DB::getInstance();
    }

} 