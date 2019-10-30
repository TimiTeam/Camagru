<?php

namespace app\models;

use app\core\Model;

class Gallery extends Model{
    public function showAllPosts(){
        $res = $this->db->row("SELECT * FROM `posts` ORDER BY id");
        return ($res);
    }
} 