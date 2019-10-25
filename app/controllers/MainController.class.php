<?php 

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller{

    public function indexAction(){
        $this->view->render("index", array('first_name' => 'TimurBoss', 'email' => 'boss_timur@gmail.com'));
    }
}