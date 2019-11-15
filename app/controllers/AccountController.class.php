<?php 

namespace app\controllers;

use app\core\Controller;


class AccountController extends Controller{

    public function loginAction($param = []){
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
        $param['arrayMasks'] = $this->model->getMasks();
        $this->view->render("MakePhoto", $param);
    }

    public function postPhotoAction($param = [])
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['posted_image']) && $this->model->makeImage()) {
               echo '/camagru/gallery/show';
               exit;
            }
            echo 'error';
        }
        else
        {
            header("Location: http://localhost:8080/camagru/");
            exit;
        }
    }
    
    public function logoutAction($param = []){
        session_unset ();
        header("Location: http://localhost:8080/camagru/");
        exit;
    }
    public function settingsAction($param = []){
        if (!isset($_SESSION['user_in']))
            header("Location: http://localhost:8080/camagru/");
		$param = $this->model->getCurrentUser($_SESSION['user_id']);
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $param = $this->model->changeUserData($param);
        }
        $this->view->render($param['login']."Account", $param);
    }
    
    public function validDataAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (isset($_POST['login'])) {
                $login = htmlspecialchars(trim($_POST["login"]));
                if (isset($login) && $this->model->isNewLogin($login)) {
                    echo 'ok';
                    exit;
                }
            }
            else if (isset($_POST['nickname'])){
                $nick = htmlspecialchars(trim($_POST["nickname"]));
                if (isset($nick) && $this->model->isNewNickname($nick)) {
                    echo 'ok';
                    exit;
                }
            }
        }
        echo "error";
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
        $param['getData'] = true;
		$param['newPassword'] = false;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['login'])){
            if (($email = htmlentities($_POST['email'])) && ($login = htmlentities($_POST['login']))){
                if ($this->model->confirmEmailAndLogin($email, $login)){
                    $this->model->resetPasswordEmail($email, $login);
                    header("Location: http://localhost:8080/camagru/account/status");
                    exit;
                }
                else{
                    $param['error'] = "This email not belong to ".$login;
                }
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
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['reset_token']) && isset($_SESSION['reset_token']) && $_GET['reset_token'] == $_SESSION['reset_token']){
            unset($_SESSION['reset_token']);
			$param['getData'] = false;
			$param['newPassword'] = true;
        }
        $this->view->render("Reset", $param);
    }

    public function statusAction($param = []){
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['token']) && isset($_GET['email'])){
            $token = $_GET['token'];
            $email = $_GET['email'];
            if ($this->model->confirmEmail($token, $email)){
                $param['info'] = "Success, yor Email confirm";
            }
            else{
                $param['info'] = "Sorry some trouble, please try again";
            }
        }
        else
            $param['info'] = 'Check your email';
        $this->view->render("Confirm email", $param);
    }
}