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

	public function getAllLikesAndCommentsCountToUser($allPosts = []){
    	$countLike = 0;
    	$contComments = 0;
    	foreach ($allPosts as $post) {
    		$countLike += $post['like'];
    		$contComments += $post['comments'];
    	}
		return array('allLikes' => $countLike, 'allComments' => $contComments);
	}

	public function getUserLikesPosts($userId){
    	$likes = $this->db->row('SELECT * FROM `likes_posts` WHERE `user_id` = :user_id', array('user_id' => $userId));
    	$userLikesPosts = [];
    	$i = 0;
    	foreach ($likes as $like){
    		$userLikesPosts[$i] =  $this->db->row('SELECT * FROM `posts` WHERE `id` = :post_id', array('post_id' => $like['post_id']));
    		$i++;
		}
    	return $userLikesPosts;
	}

	public function deletePostAndAllData($postId){
		$this->db->row("DELETE FROM likes_posts WHERE `post_id` = :post_id", array('post_id' => $postId));
		$this->db->row("DELETE FROM comments_posts WHERE `post_id` = :post_id", array('post_id' => $postId));
		$this->db->row("DELETE FROM posts WHERE `id` = :post_id", array('post_id' => $postId));
	}

    public function getUserPosts($id){
        $res = $this->db->row("SELECT * FROM `posts` WHERE `user_id` = :id", array('id' => $id));
        return ($res);
    }
} 