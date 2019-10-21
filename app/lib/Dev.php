<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

function m_debug($var){
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}