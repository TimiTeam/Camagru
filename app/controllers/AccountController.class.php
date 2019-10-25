<?php 

namespace app\controllers;

use app\core\Controller;

class AccountController extends Controller{

    public function loginAction($param = []){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if ($this->validate_form()){
                if ($this->isRegisterUser()){
                    echo 'Good';
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
    
    private function isRegisterUser(){
        $res = $this->model->db->row("SELECT * FROM `users` WHERE `login` = :logi AND `password` = :pass",
                array('logi' => $_POST['login'], 'pass' => $_POST['pass']));
        if (empty($res[0]))
            return false;
        return true;
    }

    private function validate_form() {
        if (!isset($_POST['login']) || strlen($_POST['login']) < 3 || !isset($_POST['pass']) || strlen($_POST['pass']) < 2)
            return false;
        else
            return true;
    }
}