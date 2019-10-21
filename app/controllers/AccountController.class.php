<?php 

namespace app\controllers;

use app\core\Controller;

class AccountController extends Controller{

    public function loginAction(){
        echo '<p>'.$this->route['controller'].'</p>';
    }

    public function registerAction(){
        
    }
}