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
                    $_SESSION['user_id'] = $this->model->db->column("SELECT `id` FROM `users` WHERE `login` = :logi AND `password` = :pass",
                    array('logi' => $login, 'pass' => $pass));
                    header("Location: http://localhost:8080/camagru/account/makePhoto");
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

    public function registerAction($param = []){
        $this->view->render("register", $param);
    }
    
    private function isRegisterUser($login, $pass){
        $res = $this->model->db->row("SELECT * FROM `users` WHERE `login` = :logi AND `password` = :pass",
                array('logi' => $login, 'pass' => $pass));
        if (empty($res[0]))
            return false;
        return true;
    }

    private function validate_form($login, $pass) {
        if (strlen($login) < 3 || strlen($pass) < 2)
            return false;
        else
            return true;
    }
    public function makePhotoAction($param = []){
        $this->view->render("register", $param);
    }
}