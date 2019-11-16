<?php 

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller{

    public function indexAction(){
		$user_likes = [];
        $param = [];
		if ($_SERVER['REQUEST_METHOD'] == 'GET'){
			if(isset($_GET['postId']) && isset($_GET['confirm'])){

				$postId = htmlentities($_GET['postId']);
				$this->model->deletePostAndAllData($postId);
			}
		}
        if (isset($_SESSION['user_in'])){
            $user = $this->model->getUserInfo($_SESSION['user_id']);
            if ($user)
                $param['user'] = $user;
            $posts = $this->model->getUserPosts($user['id']);
            if ($posts) {
				$param['likes'] = $this->model->getAllLikes($posts);;
				$param['posts'] = array_reverse($posts);
			}
			$param['user_posts'] = count($posts);
            $ret = $this->model->getAllLikesAndCommentsCountToUser($posts);
			$param['likesToUser'] = $ret['allLikes'];
			$param['commentsToUser'] = $ret['allComments'];
			$param['userLikesPosts'] = $this->model->getUserLikesPosts($user['id']);
			$param['userLikesPostsCount'] = count($param['userLikesPosts']);
        }
        $this->view->render("Home", $param);
    }
}