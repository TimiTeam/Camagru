<?php 

namespace app\controllers;

use app\core\Controller;

class AccountController extends Controller{

    public function loginAction($param = []){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $login = htmlentities($_POST['login']);
            $pass = htmlentities($_POST['pass']);
            if ($this->validate_form($login, $pass)){
                if ($this->isRegisterUser($login, $pass)){
                    $_SESSION['user_in'] = true;
                    $_SESSION['user_id'] = $this->model->db->column("SELECT `id` FROM `users` WHERE `login` = :logi", array('logi' => $login));
                    header("Location: http://localhost:8080/camagru/account/makePhoto");
                    exit;
                }
                else
                    $param = array('message' => 'Invalid login/password');
            }
            else
                $param['message'] = 'Fill the fields';
        }
        $this->view->layout = 'custom'; 
        $this->view->render("Login", $param);
    }

    private function checkUserInput($vars){
        $errors = [];

        foreach ($vars as $k => $v){
            if (strlen($v) < 1)
                $errors[] = "Empty field ".$k;
        }
        return ($errors);
    }

    public function registerAction($param = []){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $vars = array ('first_name' => htmlentities($_POST['first_name']),
                'last_name' => htmlentities($_POST['last_name']),
                'email' => htmlentities($_POST['email']),
                'login' => htmlentities($_POST['login']),
                'password' => htmlentities($_POST['pass']),
                'confirm' => htmlentities($_POST['confirm']));
            $errors = $this->checkUserInput($vars);
            if (!filter_var($vars['email'], FILTER_VALIDATE_EMAIL))
                $errors[] = "Wrong email format";
            if (strcmp($vars['password'], $vars['confirm']))
                $errors[] = "Passwords don't match";
            unset($vars['confirm']);
            if (!isset($errors[0])){
                if ($this->isNewLogin($vars['login'])){
                    $res = $this->addNewUser($vars);
                    $_SESSION['user_in'] = true;
                    $_SESSION['user_id'] = $this->model->db->column("SELECT `id` FROM `users` WHERE `login` = :logi", array('logi' => $vars['login']));
                    header("Location: http://localhost:8080/camagru/account/makePhoto");
                    exit;
                }
                else{
                    $errors[] = "This login exists, please enter another";
                }
            }
            $param =  array('errors_message' => $errors);
        }
        $this->view->render("register", $param);
    }
    private function isNewLogin($login){
        $res = $this->model->db->column("SELECT `id` FROM `users` WHERE `login` = :logi", array('logi' => $login));
        if ($res)
            return false;
        return true;
    }

    private function addNewUser($vars){
        $res = $this->model->db->column('INSERT INTO `users` (`first_name`, `last_name`, `email`, `login`, `password`)
        VALUES (:first_name, :last_name, :email, :login, :password);', $vars);
        return $res;
    }

    private function isRegisterUser($login, $pass){
        $res = $this->model->db->column("SELECT `id` FROM `users` WHERE `login` = :logi AND `password` = :pass",
                array('logi' => $login, 'pass' => $pass));
        if ($res)
            return true;
        return false;
    }

    private function validate_form($login, $pass) {
        if (strlen($login) < 3 || strlen($pass) < 2)
            return false;
        else
            return true;
    }
    public function makePhotoAction($param = []){
        $this->view->render("MakePhoto", $param);
    }
    public function logoutAction($param = []){
        session_unset ();
        header("Location: http://localhost:8080/camagru/");
        exit;
    }
}