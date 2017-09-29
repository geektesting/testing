<?php

namespace App\Models\Rep;

use App\Core\DB;

/**
 * Class AbstractRep
 * @package Rep
 */
abstract class AbstractRep 
{
    /**
     * @var \App\Core\DB
     */
    protected $db;

    /**
     * AbstractRep constructor.
     */
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

} 