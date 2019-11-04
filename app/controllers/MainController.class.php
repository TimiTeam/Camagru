<?php 

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller{

    public function indexAction(){
        $param = [];
        if (isset($_SESSION['user_in'])){
            $user = $this->model->getUserInfo($_SESSION['user_id']);
            if ($user)
                $param['user'] = $user;
            $posts = $this->model->getUserPosts($_SESSION['user_id']);
            if ($posts)
                $param['posts'] = $posts;
        }
        $this->view->render("Home", $param);
    }
}