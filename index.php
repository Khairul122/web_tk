<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

define('BASE_PATH', __DIR__);
define('CONTROLLER_PATH', BASE_PATH . '/controllers/');
define('MODEL_PATH', BASE_PATH . '/models/');
define('VIEW_PATH', BASE_PATH . '/views/');
define('ASSET_PATH', BASE_PATH . '/assets/');
define('UPLOAD_PATH', BASE_PATH . '/foto_sekolah/'); 
require_once 'koneksi.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Login';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

$controller = preg_replace('/[^a-zA-Z0-9_]/', '', $controller);
$action = preg_replace('/[^a-zA-Z0-9_]/', '', $action);

$controllerFile = CONTROLLER_PATH . $controller . 'Controller.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    $controllerClass = ucfirst($controller) . 'Controller';
    
    if (class_exists($controllerClass)) {
        $controllerObj = new $controllerClass();
        
        if (method_exists($controllerObj, $action)) {
            $controllerObj->$action();
        } else {
            header('HTTP/1.1 404 Not Found');
            echo '404 - Action tidak ditemukan';
        }
    } else {
        header('HTTP/1.1 404 Not Found');
        echo '404 - Controller class tidak ditemukan';
    }
} else {
    header('HTTP/1.1 404 Not Found');
    echo '404 - Controller tidak ditemukan';
}
