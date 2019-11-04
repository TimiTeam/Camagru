<?php

namespace app\models;

use app\core\Model;

class Gallery extends Model{
    public function showAllPosts(){
        $res = $this->db->row("SELECT * FROM `posts` ORDER BY id");
        return ($res);
    }

    public function updatePost($postId, $updates = []){
        if (isset($updates['like']))
            $str = "SET `like` =:data";
        else if (isset($updates['comment']))
            $str = "SET `comment` =:data";
        else
            return false;
        $res = $this->db->row('UPDATE `posts` '.$str.' WHERE id =:id ', array('data' => $updates['data'], 'id' => $postId));
    }
} 