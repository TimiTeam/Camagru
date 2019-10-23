<?php

namespace app\lib;

use PDO;
class Db{
    protected $db;

    public function __construct(){
        $config = require 'app/config/db.php';
        m_debug('mysql:host='.$config['host'].';port=3306;dbname='.$config['dbname'].' '.$config['user'].' '.$config['pass']);
        try{
            $this->db = new PDO('mysql:host='.$config['host'].';port=3306;dbname='.$config['dbname'], $config['user'], $config['pass']);
        }
        catch (PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}