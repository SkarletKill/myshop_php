<?php

session_start();        //запускаем сессию

// если в сессии нет масива корзины то создаем его
if (! isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

include_once '../config/config.php';            //инициализация настроек
include_once '../config/db.php';                //инициализация БД
include_once '../library/mainFunctions.php';    //основные функции

//determine controller for working
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) : 'Index';

//determine method for working
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

// инициализируем переменную шаблонизатора - количество элементов в корзине
$smarty->assign('cartCntItems', count($_SESSION['cart']));

loadPage($smarty, $controllerName, $actionName);