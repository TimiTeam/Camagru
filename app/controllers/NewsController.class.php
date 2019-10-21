<?php 

namespace app\controllers;

use app\core\Controller;

class NewsController extends Controller{

    public function showAction(){
        echo '<p>'.$this->route['controller'].'</p>';
        echo '<p> News... </p>';
    }
}