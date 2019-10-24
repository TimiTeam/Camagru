<?php 

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller{

    public function indexAction(){
        echo '<p> In main page</p>';
        $res = $this->model->getNews();
       // m_debug( $res);
       foreach ($res as $key) {
            $this->view->render("index", $key);
       }
    }

}