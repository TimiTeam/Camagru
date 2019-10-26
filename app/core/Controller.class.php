<?php
namespace app\core;

use app\core\View;
use app\lib\Db;

abstract class Controller{
    public $route;
    public $view;
    public $model;
    
    public function __construct($route){
        $this->route = $route;
        $this->view = new View($this->route);
        $this->model = $this->loadModel($this->route['controller']);
    }

    public function loadModel($name){
        $pth = 'app\models\\'.ucfirst($name);
        if (class_exists($pth))
            return new $pth;
    }
} 