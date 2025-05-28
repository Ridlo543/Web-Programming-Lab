<?php
session_start();
require_once 'database/config.php';
require_once 'controllers/UserController.php';
require_once 'controllers/AuthController.php';

$controller = new UserController($pdo);
$authController = new AuthController($pdo);

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = explode('/', $url);

$action = isset($url[0]) && !empty($url[0]) ? $url[0] : 'index';
$id = isset($url[1]) ? $url[1] : null;

switch ($action) {
    case 'login':
        $authController->login();
        break;
    case 'doLogin':
        $authController->doLogin();
        break;
    case 'register':
        $authController->register();
        break;
    case 'doRegister':
        $authController->doRegister();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'edit':
        if ($id) $controller->edit($id);
        break;
    case 'update':
        if ($id) $controller->update($id);
        break;
    case 'delete':
        if ($id) $controller->delete($id);
        break;
    case 'show':
        if ($id) $controller->show($id);
        break;
    default:
        $controller->index();
        break;
}