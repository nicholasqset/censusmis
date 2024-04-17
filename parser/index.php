<?php

session_start();

require_once '../config/db.php';
require_once '../lib/Controller.php';


if (isset($_REQUEST['function']) && !empty($_REQUEST['function'])) {
    $controller = new Controller();
    $method = $_REQUEST['function'];
    if (method_exists($controller, $method)) {
        $return = $controller->$method();
        if (!empty($return)) {
            echo $return;
        } else {
            echo 'method has no return';
        }
    } else {
        echo 'method doesnt exist';
    }
} else {
    echo 'no function parameter posted';
}
