<?php
/**
 * Created by NeO
 * Date: 23.05.2018
 */

/**
 * Контроллер главной страницы
 *
 */

include_once '../models/CategoriesModel.php';
include_once '../models/ProductsModel.php';

function testAction(){
    echo 'IndexController.php > testAction';
}

/**
 * Формирование главной страницы сайта
 *
 * @param $smarty
 */
function indexAction($smarty){
    $rsCategories = getAllMainCategoriesWithChildren();
    $rsProducts = getLastProducts(16);

    $smarty->assign('pageTitle', 'SiteMainPage');
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProducts', $rsProducts);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'index');
    loadTemplate($smarty, 'footer');
}

