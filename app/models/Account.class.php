<?php

namespace app\models;

use app\core\Model;

class Account extends Model{
    public function getNews(){
        $res = $this->db->row("SELECT * FROM `users`");
        return ($res);
    }
} 