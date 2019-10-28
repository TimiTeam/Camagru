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
    public function validLoginAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $login = htmlspecialchars(trim($_POST["login"]));
            if (isset($login) && $this->model->isNewLogin($login))
                echo 'ok';
            else
                echo 'login exist';
        }
    }

    public function validPasswordAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $login = $_SESSION['user_login'];
            $pass = htmlspecialchars(trim($_POST["curr_pass"]));
            if ($this->model->isRegisterUser($login, $pass))
                echo 'ok';
            else
                echo $$login;
        }
    }

    public function statusAction($param = []){
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['token']) && isset($_GET['email'])){
            $token = $_GET['token'];
            $email = $_GET['email'];
            if ($this->model->confirmEmail($token, $email))
                $param['info'] = "Success, yor Email confirm";
            else
                $param['info'] = "Sorry some trouble, please try again";
        }
        else
            $param['info'] = 'Check your email';
        $this->view->render("Confirm email", $param);
    }
}