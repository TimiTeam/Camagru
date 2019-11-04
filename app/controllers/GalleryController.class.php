<?php 

namespace app\controllers;

use app\core\Controller;

class GalleryController extends Controller{

    public function showAction(){
        $res = [];
        $res = $this->model->showAllPosts();
        if ($res)
            $res = array_reverse($res);
        $this->view->render("Gallery", array('data' => $res));
    }

    public function likePostAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pos_id']) && isset($_POST['like'])){
            $this->model->updatePost($_POST['pos_id'], array('like' => 1, 'data' => $_POST['like']));
            echo 'ok';
            exit;
        }
        echo 'error';
    }
}