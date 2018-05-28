<?php
/**
 * Created by NeO
 * Date: 26.05.2018
 */

/**
 * Контроллер страницы категорий (/category/1)
 *
 */

//подключение модели
include_once '../models/CategoriesModel.php';
include_once '../models/ProductsModel.php';

/**
 * Формирование страницы категорий
 *
 * @param object $smarty шаблонизатор
 */
function indexAction($smarty)
{
    $categoryId = isset($_GET['id']) ? $_GET['id'] : null;
    if($categoryId == null) exit();
//    echo "Category test _ {$categoryId}";

    $rsChildCategories = null;
    $rsProducts = null;
    $rsCategory = getCategoryById($categoryId);

    // если категория главная, то показываем дочерние категории
    // иначе показываем товары
    if ($rsCategory['parrent_id'] == 0) {
        $rsChildCategories = getChildrenForCategory($categoryId);
    } else {
        $rsProducts = getProductsByCategory($categoryId);
    }

    $rsCategories = getAllMainCategoriesWithChildren();

    $smarty->assign('pageTitle', 'Товары категории '.$rsCategory['name']);

    $smarty->assign('rsCategory', $rsCategory);
    $smarty->assign('rsProducts', $rsProducts);
    $smarty->assign('rsChildCategories', $rsChildCategories);

    $smarty->assign('rsCategories', $rsCategories);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'category');
    loadTemplate($smarty, 'footer');
}