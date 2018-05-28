<?php
/**
 * Created by NeO
 * Date: 27.05.2018
 */

/**
 * Контроллер страницы товара (/product/1)
 *
 */

// подключаем модели
include_once '../models/ProductsModel.php';
include_once '../models/CategoriesModel.php';

/**
 * Формирование страницы продукта
 *
 * @param object $smarty шаблонизатор
 */
function indexAction($smarty)
{
    $itemId = isset($_GET['id']) ? $_GET['id'] : null;
    if($itemId == null) exit();

    // получить название продукта
    $rsProducts = getProductById($itemId);

    // получить все категории
    $rsCategories = getAllMainCategoriesWithChildren();

    $smarty->assign('pageTitle', '');
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProduct', $rsProducts);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'product');
    loadTemplate($smarty, 'footer');
}