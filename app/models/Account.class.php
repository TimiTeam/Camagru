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
                \m_debug($res);
                $_SESSION['user_login'] = $vars['login'];
                $_SESSION['user_id'] = $this->db->column("SELECT `id` FROM `users` WHERE `login` =:login", array('login' => $vars['login']));
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
            foreach ($vars as $k => $v){
                $new_data[$k] = $v;
            }
            if (isset($vars['password']))
                $new_data['password'] = password_hash($vars['password'], PASSWORD_DEFAULT);
            unset($new_data['verified']);
            unset($new_data['token']);
            $res = $this->db->row("UPDATE `users` SET `first_name` = :first_name, `last_name` = :last_name, 
            `email` = :email, `login` = :login, `password` =:password, `notify` = :notify WHERE id = :id " , $new_data);
            $_SESSION['user_login'] = $new_data['login'];
            header("Location: http://localhost:8080/camagru/account/setting");
            exit;
        }
    }

    public function getMasks(){
        $mas[] = '/camagru/app/res/cat.png';
        $mas[] = '/camagru/app/res/anotherCat.png';
        $mas[] = '/camagru/app/res/mask.png';
        return $mas;
    }

    public function isNewLogin($login){
        $res = $this->db->column("SELECT `id` FROM `users` WHERE `login` = :logi", array('logi' => $login));
        if ($res)
            return false;
        return true;
    }

    private function addNewUser($vars){
        $res = $this->db->row('INSERT INTO `users` (`first_name`, `last_name`, `email`, `login`, `password`, `token`)
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

    public function makeImage(){
        $data = htmlspecialchars($_POST['posted_image']);
        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]);
        
            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                throw new \Exception('invalid image type');
            }
            $data = base64_decode($data);
            if ($data === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }
        $user = $_SESSION['user_login'];
        $date = date("H:i:s_m.d.y");
        $user_id = $_SESSION['user_id'];
        $title = htmlentities($_POST['title']);
        $fileName = "users_photo/img_{$user}_{$date}.{$type}";
        file_put_contents($fileName, $data);
        $res = $this->db->row('INSERT INTO `posts` (`user_id`, `published`, `title`, `path_photo`)
        VALUES (:usr_id, :published, :title, :path_photo);', array('usr_id' => $user_id, 'published' => date("Y-m-d H:i:s"), 'title' => $title, 'path_photo' => $fileName));
        return (true);
    }

    private function sendMail($user){
        $to      = $user['email'];
        $subject = 'Registration';
        $message = 'Hey, you confirm registration on camagru at '.date("d.m.Y", time()).' by user: '.$user['login'].' Go to the link
        <a href="http://localhost:8080/camagru/account/status?token='.$user['token'].'&email='.$to .'">'.'http://localhost:8080/camagru/account/status?token='.$user['token'].'</a>';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        mail($to, $subject, $message, $headers);
    }

    public function resetPasswordEmail($email, $login){
        $to      = $email;
        $subject = 'Reset password';
        $_SESSION['reset_token'] = $this->generate_string(10);
        $message = 'Hey, '.$login.' want to reset password. Go to the link to reset or just ignore is.
        <a href="http://localhost:8080/camagru/account/reset?reset_token='.$_SESSION['reset_token'].'&email='.$to .'">'.'http://localhost:8080/camagru/account/reset?reset_token='.$_SESSION['reset_token'].'</a>';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $res = mail($to, $subject, $message, $headers);
    }

    public function confirmEmailAndLogin($email, $login){
        $res = $this->db->row("SELECT * FROM `users` WHERE `login` = :logi", array('logi' => $login));
        if ($res){
            if ($res[0]['email'] == $email){
                $_SESSION['user_id'] = $res[0]['id'];
                return true;
            }
        }
        return false;
    }

    public function updatePassword($newPassord){
        $newPassord = password_hash($newPassord, PASSWORD_DEFAULT);
        $id = $_SESSION['user_id'];
        $res = $this->db->row("UPDATE `users` SET `password` =:password WHERE id = :id ;" , array('password' => $newPassord, 'id' => $id));
    }

    public function getCurrentUser($id){
        $res = $this->db->row("SELECT * FROM `users` WHERE `id` = :id",
                array('id' => $id));
        return $res[0];
    }

    public function deleteAccount($id){
        $res = $this->db->row("DELETE FROM `users` WHERE id = :id ", array('id' =>  $id));
    }

    public function confirmEmail($token, $email){
        if(!isset($_SESSION['user_id']))
            return false;
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