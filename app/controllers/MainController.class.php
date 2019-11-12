<?php 

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller{

    public function indexAction(){
        $param = [];
		$likes = [];
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
            $posts = $this->model->getUserPosts($_SESSION['user_id']);
            if ($posts) {
				$likes = $this->model->getAllLikes($posts);
				$param['likes'] = $likes;
				$param['posts'] = array_reverse($posts);
			}
        }
        $this->view->render("Home", $param);
    }
}