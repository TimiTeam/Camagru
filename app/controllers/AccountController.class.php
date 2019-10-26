<?php 

namespace app\controllers;

use app\core\Controller;

class AccountController extends Controller{

    public function loginAction($param = []){
        $this->view->layout = 'custom'; 
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
            $param = $this->model->login();
        $this->view->render("Login", $param);
    }

    public function registerAction($param = []){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $param = $this->model->register();
        }
        $this->view->render("register", $param);
    }

    public function makePhotoAction($param = []){
        $this->view->render("MakePhoto", $param);
    }
    public function logoutAction($param = []){
        session_unset ();
        header("Location: http://localhost:8080/camagru/");
        exit;
    }
    public function settingAction($param = []){
        if (!isset($_SESSION['user_in']))
            header("Location: http://localhost:8080/camagru/");
        $user = $this->model->getCurrentUser($_SESSION['user_id']);
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $param = $this->model->changeUserData($user);
        }
        $this->view->render($user['login']."Account", $user);
    }
}