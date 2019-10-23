<?php 

namespace app\controllers;

use app\core\Controller;

class AccountController extends Controller{

    public function loginAction(){
        $this->view->layout = 'custom';
        $this->view->render("Login");
    }

    public function registerAction(){
        $this->view->render("Register");
    }
}