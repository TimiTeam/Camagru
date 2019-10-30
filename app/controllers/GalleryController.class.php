<?php 

namespace app\controllers;

use app\core\Controller;

class GalleryController extends Controller{

    public function showAction(){
        $res = [];
        $res = $this->model->showAllPosts();
     //   \m_debug($res);
     //   exit;
        $res = array_reverse($res);
        $this->view->render("Gallery", array('data' => $res));
    }
}