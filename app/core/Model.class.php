<?php

namespace app\core;

use app\lib\Db;

abstract class Model{
    public $db;
    public function __construct(){
        echo '<p> Created </p>';
        $this->db = new Db;
    }
}

