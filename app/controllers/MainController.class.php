<?php 

namespace app\controllers;

use app\core\Controller;
use app\lib\Db;

class MainController extends Controller{

    public function indexAction(){
        $db = new Db;
        $vars = [
            'name' => 'Tim',
            'age' => '22'
        ];
        $this->view->render("Main", $vars);
    }
}