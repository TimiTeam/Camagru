<?php 

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller{

    public function indexAction(){
        echo '<p>'.$this->route['controller'].'</p>';
        echo '<p> In Main page </p>';
    }
}