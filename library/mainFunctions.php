<?php
/**
 * Created by NeO
 * Date: 23.05.2018
 */

/**
 *
 * Основные функции
 *
 */

/**
 * Формирование запрашиваемой страницы
 *
 * @param $smarty
 * @param string $controllerName название контроллера
 * @param string $actionName название функции обработки страницы
 */
function loadPage($smarty, $controllerName, $actionName = 'index'){
    include_once PathPrefix . $controllerName . PathPostfix;

    $function = $actionName . 'Action';
    $function($smarty);
}

/**
 * Загрузка шаблона
 *
 * @param $smarty
 * @param $templateName
 */
function loadTemplate($smarty, $templateName){
    $smarty->display($templateName . TemplatePostfix);
}

/**
 * Функция отладки. Останавливает работу программы выводя значение
 * переменной $value
 *
 * @param variant $value
 * @param boolean $die
 */
function d($value = null, $die = true){
    echo 'Debug: <br/><pre>';
    print_r($value);
    echo '</pre>';

    if($die) die;
}

/**
 * Преобразование результата работы функции выборки в ассоциативный масив
 *
 * @param recordSet $rs набор строк - результат работы SELECT
 * @return array
 */
function createSmartyRsArray($rs){
    if(!$rs) return false;

    $smartyRs = array();
    while($row = $rs->fetch()){
        $smartyRs[] = $row;
    }

    return $smartyRs;
}

/**
 * Редирект
 *
 * @param string $url адрес для перенаправления
 */
function redirect($url = '/'){
    if(!$url) $url = '/';
    header("Location: {$url}");
    exit;
}