<?php

namespace app\models;

use app\core\Model;

class Account extends Model{

    public function login(){
        $param = [];
        $login = htmlentities($_POST['login']);
        $pass = htmlentities($_POST['pass']);
        if ($this->validate_form($login, $pass)){
            if ($this->isRegisterUser($login, $pass)){
                $_SESSION['user_in'] = true;
                $_SESSION['user_login'] = $login;
                $_SESSION['user_id'] = $this->db->column("SELECT `id` FROM `users` WHERE `login` = :logi", array('logi' => $login));
                header("Location: http://localhost:8080/camagru/account/makePhoto");
                exit;
            }
            else
                $param['message'] = 'Invalid login/password';
        }
        else
            $param['message'] = 'Fill the fields';
        return ($param);
    }

    private function generate_string($strength = 16) {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($permitted_chars);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }

    public function register(){
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
        $vars['password'] = password_hash($vars['password'], PASSWORD_DEFAULT);
        $vars['token'] = $this->generate_string(30);
        $this->sendMail($vars);
        if (!isset($errors[0])){
            if ($this->isNewLogin($vars['login'])){
                $res = $this->addNewUser($vars);
                $_SESSION['user_login'] = $vars['login'];
                $_SESSION['user_id'] = $this->db->column("SELECT `id` FROM `users` WHERE `login` = :logi", array('logi' => $vars['login']));
                header("Location: http://localhost:8080/camagru/account/status");
                exit;
            }
            else{
                $errors[] = "This login exists, please enter another";
            }
        }
        return (array('errors_message' => $errors));
    }

    public function changeUserData($user){
        $vars = array ('first_name' => htmlentities($_POST['first_name']),
            'last_name' => htmlentities($_POST['last_name']),
            'email' => htmlentities($_POST['email']),
            'login' => htmlentities($_POST['login']),
            'notify' => htmlentities($_POST['notify']),
            'password' => htmlentities($_POST['password']));
        $vars = array_diff($vars, array('', NULL, false));
        if (isset($vars['email']) && !filter_var($vars['email'], FILTER_VALIDATE_EMAIL))
            $errors[] = "Wrong email format";
        if (!isset($errors[0])){
            $new_data = $user;
            unset($new_data['id']);
            foreach ($vars as $k => $v){
                $new_data[$k] = $v;
            }
            if (isset($vars['password']))
                $new_data['password'] = password_hash($vars['password'], PASSWORD_DEFAULT);
            $res = $this->db->row("UPDATE `users` SET `first_name` = :first_name, `last_name` = :last_name, 
            `email` = :email, `login` = :login, `password` =:password, `notify` = :notify WHERE id = ".$user['id']." ;" , $new_data);
            header("Location: http://localhost:8080/camagru/account/setting");
            exit;
        }
    }

    public function isNewLogin($login){
        $res = $this->db->column("SELECT `id` FROM `users` WHERE `login` = :logi", array('logi' => $login));
        if ($res)
            return false;
        return true;
    }

    private function addNewUser($vars){
        $res = $this->db->column('INSERT INTO `users` (`first_name`, `last_name`, `email`, `login`, `password`, `token`)
        VALUES (:first_name, :last_name, :email, :login, :password, :token);', $vars);
        return $res;
    }

    public function isRegisterUser($login, $pass){
        $res = $this->db->column("SELECT `password` FROM `users` WHERE `login` = :logi;",
            array('logi' => $login));
        if (password_verify($pass, $res))
            return true;
        return false;
    }

    private function validate_form($login, $pass) {
        if (strlen($login) < 3 || strlen($pass) < 2)
            return false;
        else
            return true;
    }

    private function checkUserInput($vars){
        $errors = [];

        foreach ($vars as $k => $v){
            if (strlen($v) < 2)
                $errors[] = $k." - to short";
        }
        return ($errors);
    }

    private function sendMail($user){
        $to      = $user['email'];
        $subject = 'Registration';
        $message = 'Hey, you confirm registration on camagru at '.date("d.m.Y", time()).' by user: '.$user['login'].' Go to the link
        <a href="http://localhost:8080/camagru/account/status?token='.$user['token'].'&email='.$to .'">'.'http://localhost:8080/camagru/account/status?token='.$user['token'].'</a>';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
       /* $headers = array(
            'From' => 'webmaster@example.com',
            'Reply-To' => 'webmaster@example.com',
            'X-Mailer' => 'PHP/' . phpversion()
        );
*/        mail($to, $subject, $message, $headers);
    }

    public function getCurrentUser($id){
        $res = $this->db->row("SELECT * FROM `users` WHERE `id` = :id",
                array('id' => $id));
        return $res[0];
    }

    public function confirmEmail($token, $email){
        $user = $this->getCurrentUser($_SESSION['user_id']);
        if ($user['token'] == $token && $email == $user['email'])
        {
            $_SESSION['user_in'] = true;
            $res = $this->db->row("UPDATE `users` SET `token` = :token, `verified` = :verified WHERE id = ".$user['id']." ;", array('token' =>  "", 'verified' => "1" ));
            return (true);
        }
        return false;
    }
}