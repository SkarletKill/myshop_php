<?php

session_start();            //запускаем сессию
define('ROOT', __DIR__);    //корневая директория

// если в сессии нет масива корзины то создаем его
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

include_once '../config/config.php';            //инициализация настроек
include_once '../config/db.php';                //инициализация БД
include_once '../library/mainFunctions.php';    //основные функции

//determine controller for working
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) : 'Index';

//determine method for working
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

// если в сессии есть данные об авторизованом пользователе,
// то передаем их в шаблон
if (isset($_SESSION['user'])) {
    $smarty->assign('arrUser', $_SESSION['user']);
}

// инициализируем переменную шаблонизатора - количество элементов в корзине
$smarty->assign('cartQuantityItems', count($_SESSION['cart']));

loadPage($smarty, $controllerName, $actionName);