<?php

namespace app\models;

use app\core\Model;

class Main extends Model{
    public function getUserInfo($id){
        $res = $this->db->row("SELECT * FROM `users` WHERE id = :id", array('id' => $id));
        if(isset($res[0]))
            return ($res[0]);
        return false;
    }

    public function getUserPosts($id){
        $res = $this->db->row("SELECT * FROM `posts` WHERE `user_id` = :id", array('id' => $id));
        return ($res);
    }
} 