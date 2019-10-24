<?php 

namespace app\controllers;

use app\core\Controller;

class AccountController extends Controller{

    public function loginAction($param = []){
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

    public function checkAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if ($this->validate_form() && $this->isRegisterUser())
                echo '<p><b>Welcome '.$_POST['login'].'</b></p>';
            else
        
            {
                $this->view->path = 'account/login';
                $this->loginAction();
            }
        }
        else
        {
            $this->view->path = 'account/login';
            $this->loginAction();
        }
    }
    private function validate_form() {
        if (!isset($_POST['login']) || strlen($_POST['login']) < 3 || !isset($_POST['pass']) || strlen($_POST['pass']) < 2)
            return false;
        else
            return true;
    }
}