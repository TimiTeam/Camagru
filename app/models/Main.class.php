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

	public function getPostLikes($postId){
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

    public function getUserPosts($id){
        $res = $this->db->row("SELECT * FROM `posts` WHERE `user_id` = :id", array('id' => $id));
        return ($res);
    }
} 