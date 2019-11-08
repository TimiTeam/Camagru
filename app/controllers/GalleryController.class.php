<?php 

namespace app\controllers;

use app\core\Controller;

class GalleryController extends Controller{

    public function showAction(){
        $res = [];
        if (isset($_GET['nickname'])){
            $nickname = htmlentities($_GET['nickname']);
            $res = $this->model->getAllUserPosts($nickname);
        }
        else
            $res = $this->model->showAllPosts();
        if ($res)
            $res = array_reverse($res);
        $this->view->render("Gallery", array('data' => $res));
    }

    public function likePostAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pos_id']) && isset($_POST['like'])){
            if (!isset($_SESSION['like_'.$_POST['pos_id']]))
                $_SESSION['like_'.$_POST['pos_id']] = 1;             
            else
                unset($_SESSION['like_'.$_POST['pos_id']]);
            $this->model->updatePost($_POST['pos_id'], array('like' => 1, 'data' => $_POST['like']));
            echo 'ok';
            exit;
        }
        echo 'error';
    }

    public function showPostAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['post_id'])){
            $comments = [];
            $userLikes = [];
            $post_id = htmlentities($_GET['post_id']);
            $post = $this->model->getCurrentPost($post_id);
            if ($post == false) {
                echo '<h3>Post not exist</h3>';
                exit;
            }
            $this->view->render("Post", array('data' => $post, 'comments' => $comments, 'likes' => $userLikes));
        }
        exit;
    }

    public function accountAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['user_id'])){
            $user_id = htmlentities($_GET['user_id']);
            $user = $this->model->getUserInfo($user_id);
            if ($user != false) {
                $posts = $this->model->getAllUserPosts($user['nickname']);
                $this->view->render($user['nickname'], array('userInfo' => $user,'data' => $posts));
            }
        }
        exit;
    }
}