<?php 

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller{

    public function indexAction(){
        $param = [];
		$likes = [];
        if (isset($_SESSION['user_in'])){
            $user = $this->model->getUserInfo($_SESSION['user_id']);
            if ($user)
                $param['user'] = $user;
            $posts = $this->model->getUserPosts($_SESSION['user_id']);
            if ($posts) {
				$likes = $this->model->getAllLikes($posts);
				$param['likes'] = $likes;
				$param['posts'] = $posts;
			}
        }
        $this->view->render("Home", $param);
    }
}