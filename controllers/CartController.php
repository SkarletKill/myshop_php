<?php
/**
 * Created by NeO
 * Date: 27.05.2018
 */

/**
 * Контроллер работы с корзиной (/cart/)
 *
 */

// подключаем модели
include_once '../models/CategoriesModel.php';
include_once '../models/ProductsModel.php';

/**
 * Добавление продукта в корзину
 *
 * @param integer id GET параметр - ID добавляемого продукта
 * @return json информаци об операции (успех, количество елементов в корзине)
 */
function addtocartAction()
{
    $itemId = isset($_GET['id']) ? intval($_GET['id']) : null;
    if (!$itemId) return false;
//    d($itemId);
    $resData = array();

    // если значение не найдено, то добавляем
    if (isset($_SESSION['cart']) && array_search($itemId, $_SESSION['cart']) === false) {
        $_SESSION['cart'][] = $itemId;
        $resData['quantityItems'] = count($_SESSION['cart']);
        $resData['success'] = 1;
    } else {
        $resData['success'] = 0;
    }

    echo json_encode($resData);
}

/**
- * Удаление продукта из корзины
- *
- * @param integer id GET параметр - id удаляемого из корзины продукта
- * @return json информацио об опечатках (успех, количество элементов в корзине)
- */
function removefromcartAction()
{
    $itemId = isset($_GET['id']) ? intval($_GET['id']) : null;
    if (!$itemId) exit();

    $resData = array();
    $key = array_search($itemId, $_SESSION['cart']);
    if ($key !== false) {
        unset($_SESSION['cart'][$key]);
        $resData['success'] = 1;
        $resData['quantityItems'] = count($_SESSION['cart']);
    } else {
        $resData['success'] = 0;
    }
    echo json_encode($resData);
}

/**
 * Формирование страницы корзины
 * @link /cart/
 */
function indexAction($smarty){
    $itemsId = isset($_SESSION['cart'])? $_SESSION['cart']: array();

    $rsCategories = getAllMainCategoriesWithChildren();
    $rsProducts = getProductsFromArray($itemsId);

    $smarty->assign('pageTitle', 'Корзина');
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProducts', $rsProducts);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'cart');
    loadTemplate($smarty, 'footer');
}