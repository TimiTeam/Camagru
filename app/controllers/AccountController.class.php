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
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->model->makeImage();
            exit;
        }
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

    public function resetAction($param = []){
        $input = '<p> Login <br>
        <input type="text" name="login" required>
    </p>
    <p> Email <br>
        <input type="email" name="email" required>
    </p>
    <p>';
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['login'])){
            if (($email = htmlentities($_POST['email'])) && ($login = htmlentities($_POST['login']))){
                if ($this->model->confirmEmailAndLogin($email, $login)){
                    $this->model->resetPasswordEmail($email, $login);
                    header("Location: http://localhost:8080/camagru/account/status");
                    exit;
                }
                else
                    $param['error'] = "This email not belong to ".$login;
            }
            else
                $param['error'] = "Input error, try again";
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password']) && isset($_POST['confirm']) && $_POST['confirm'] == $_POST['password']){
            $pass = htmlspecialchars(trim($_POST['password']));
            $this->model->updatePassword($pass);
            header("Location: http://localhost:8080/camagru/account/login");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['reset_token']) && isset($_GET['email']) && $_GET['reset_token'] == $_SESSION['reset_token']){
            unset($_SESSION['reset_token']);
            $input = '<p> New password <br>
        <input type="password" name="password" required>
    </p>
    <p> Confirm  <br>
        <input type="password" name="confirm" required>
    </p>
    <p>';
        }
        $param['data'] = $input;
        $this->view->render("Reset", $param);
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