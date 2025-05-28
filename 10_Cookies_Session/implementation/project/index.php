<?php

require_once 'database/config.php';
require_once 'controllers/UserController.php';

$controller = new UserController($pdo);

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = explode('/', $url);

$action = isset($url[0]) && !empty($url[0]) ? $url[0] : 'index';
$id = isset($url[1]) ? $url[1] : null;

switch ($action) {
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
