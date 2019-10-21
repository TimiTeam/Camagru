<?php

namespace app\core;

class Router {

    protected $routs = [];
    protected $params = [];

    function __construct(){
        $arr = require'app/config/routes.php';
        echo "<h2 align=center>It's ME</h2>";
        foreach ($arr as $key => $val)
            $this->add($key, $val);
    }
    public function add($route, $params){
        $route = '#^'.$route.'$#';
        $this->routs[$route] = $params;
    }

    public function match(){
        $url = trim($_SERVER['REQUEST_URI'],'/');
        foreach ($this->routs as $route => $params){
            if (preg_match($route, $url, $matches)){
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run(){
        if ($this->match()){
            $path = 'app\controllers\\'.ucfirst($this->params['controller'].'Controller');
            if (class_exists($path)){
                $action = $this->params['action'].'Action';
                if (method_exists($path, $action)){
                    echo "<p align=center>Functions found: <b>".$action."</p>";
                    $controller = new $path;
                    $controller->$action();
                }
                else{
                    echo "<p align=center>Not found functions: <b>".$action."</p>";
                }
            }
            else {
                echo "<p align=center>Class not fount <b>".$path.".class.php</p>";
            }
        }
    }
}