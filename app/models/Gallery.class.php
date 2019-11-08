<?php

namespace app\models;

use app\core\Model;

class Gallery extends Model{
    public function showAllPosts(){
        $res = $this->db->row("SELECT * FROM `posts` ORDER BY id");
        return ($res);
    }

    public function deleteLine($posId, $user){
        $res = $this->db->row( 'DELETE FROM `likes_posts` WHERE `user_id` = :user_id AND `post_id` = :post_id;', array('user_id' => $user['id'], 'post_id' => $posId));
    }

    public function addLike($posId, $user){
        $res = $this->db->row('INSERT INTO `likes_posts` (`post_id`, `user_id`, `nickname`) VALUES( :post_id , :user_id , :nickname) ',
        array('post_id' => $posId, 'user_id' => $user['id'], 'nickname' => $user['nickname']));
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
    public function getCurrentPost($post_id){
        $res = $this->db->row("SELECT * FROM `posts` WHERE `id` = :post_id", array('post_id' => $post_id));
        if (isset($res[0]))
            return ($res[0]);
        return false;
    }

    public function getAllUserPosts($user_name){
        $res = $this->db->row("SELECT * FROM `posts` WHERE `user_name` = :user_name", array('user_name' => $user_name));
        return $res;
    }

    public function getUserInfo($user_id){
        $res = $this->db->row("SELECT * FROM `users` WHERE `id` = :user_id", array('user_id' => $user_id));
        if (isset($res[0]))
        {
            $ret = $res[0];
            unset($ret['password']);
            unset($ret['login']);
            return $ret;
        }
        else
            return false;
    }

    private function getPostLikes($postId){
        $res = $this->db->row("SELECT * FROM `likes_posts` WHERE `post_id` = :post_id", array('post_id' => $postId));
        return $res;
    }

    public function getAllLikes($allPosts){
        $likes = [];
        foreach ($allPosts as $post) {
            $likes[$post['id']] = $this->getPostLikes($post['id']);
        }
        return $likes;
    }
}