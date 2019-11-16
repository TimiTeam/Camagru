<?php

namespace app\models;

use app\core\Model;

class Gallery extends Model{
    public function showAllPosts(){
        $res = $this->db->row("SELECT * FROM `posts` ORDER BY `published`");
        return ($res);
    }

    public function getAllPostsByLikes(){
		$res = $this->db->row("SELECT * FROM `posts` ORDER BY `like`");
		return ($res);
	}

	public function getAllUserPostsByLikes($nickname){
		$res = $this->db->row("SELECT * FROM `posts` WHERE `user_name` = :id  ORDER BY `like`", array('id' => $nickname));
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
            $str = "SET `comments` =:data";
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

    public function getPostLikes($postId){
        $res = $this->db->row("SELECT * FROM `likes_posts` WHERE `post_id` = :post_id", array('post_id' => $postId));
        return $res;
    }

	public function getPostComments($postId){
		$res = $this->db->row("SELECT * FROM `comments_posts` WHERE `post_id` = :post_id", array('post_id' => $postId));
		return $res;
	}

	private function sendCommentInEmail($from, $to, $mess, $postId){
		$subject = 'New comment';
		$message = 'Hello '.$to['first_name'].' '.$to['last_name'].'<br> <a href="http://localhost:8080/camagru/gallery/account?user_id='.$from['id'].'">'.$from['nickname'].
			' </a> Leave the comment about your post. <a href="http://localhost:8080/camagru/gallery/showPost?post_id='.$postId.'">Here</a>:<br> '.$mess;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		//$headers .= 'To: '.$to['first_name'].' '.$to['email']."\r\n";
		//$headers .= 'From: '.$from['nickname'].' '.$from['email']."\r\n";
		//$headers .= ''.$from['email']."\r\n";
		//$headers .= ''.$from['email']."\r\n";
		$res = mail($to['email'], $subject, $message, $headers);
	}

	public function updateCommentToPost($post, $comment){
    	$user = $this->getUserInfo($_SESSION['user_id']);
    	$res = [];
    	if ($user && $post) {
    		$count = intval($post['comments']) + 1;
			$res['comment'] = $this->db->row("INSERT INTO comments_posts (`post_id`, `user_id`, `nickname`, `comment`) VALUES (:post_id, :user_id, :nickname, :comment)",
				array('post_id' => $post['id'], 'user_id' => $user['id'], 'nickname' => $user['nickname'], 'comment' => $comment));
			$res['post_update'] = $this->updatePost($post['id'], array('comment' => 1, 'data' => $count));
			$to =  $this->getUserInfo($post['user_id']);
			if ($to['notify'] == 1){
				$this->sendCommentInEmail($user, $to, $comment, $post['id']);
			}
		}
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