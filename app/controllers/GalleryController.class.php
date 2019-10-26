<?php 

namespace app\controllers;

use app\core\Controller;

class GalleryController extends Controller{

    public function showAction(){
        $res = [];
        $res = $this->model->showAllPosts();
        $this->view->render("Gallery", $res);
    }
}