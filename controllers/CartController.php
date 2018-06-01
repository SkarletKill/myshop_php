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
include_once '../models/OrdersModel.php';
include_once '../models/PurchaseModel.php';

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
 * - * Удаление продукта из корзины
 * - *
 * - * @param integer id GET параметр - id удаляемого из корзины продукта
 * - * @return json информацио об опечатках (успех, количество элементов в корзине)
 * - */
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
function indexAction($smarty)
{
    $itemsId = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

    $rsCategories = getAllMainCategoriesWithChildren();
    $rsProducts = getProductsFromArray($itemsId);

    $smarty->assign('pageTitle', 'Корзина');
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProducts', $rsProducts);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'cart');
    loadTemplate($smarty, 'footer');
}

/**
 * Формирование страницы зкакза
 *
 * @param $smarty - шаблонизатор
 */
function orderAction($smarty)
{
    // получаем масив идентификаторов (ID) продуктов корзины
    $itemsId = $_SESSION['cart'] ?? null;
    // если корзина пуста то редирект -> корзина
    if (!$itemsId) {
        redirect('/cart/');
        return;
    }

    // получаем из масива $_POST количество покупаемых товаров
    $itemsQuantity = array();
    foreach ($itemsId as $item) {
        // формируем ключ для масива $_POST
        $itemQKey = 'itemQuantity_' . $item;
        // создаем елемент масива количества покупаемого товара
        // ключ масива - ID товара, значение - количество товара
        // $itemsQuantity[1] = 3; товар с ID == 3 покупают 3 штуки
        $itemsQuantity[$item] = $_POST[$itemQKey] ?? null;
    }

    // получаем список продуктов корзины
    $rsProducts = getProductsFromArray($itemsId);

    // добавляем каждому продукту дополнительное поле
    // real price = количество продуктов * цена
    // quantity = количество покупаемого товара

    // &$item - для того чтобы при изменении элементов
    // $item менялся и элемент массива $rsProducts
    $i = 0;
    foreach ($rsProducts as &$prod) {
        $prod['quantity'] = $itemsQuantity[$prod['id']] ?? 0;
        if ($prod['quantity']) {
            $prod['realPrice'] = $prod['quantity'] * $prod['price'];
        } else {
            // если вдруг получилось так, что товар в корзине есть, а количество == нулю,
            // то удаляем этот товар
            unset($rsProducts[$i]);
        }
        $i++;
    }

    if (!$rsProducts) {
        echo "Корзина пуста!";
        return;
    }

    // полученный массив покупаемых товаров помещаем в сессионную переменную
    $_SESSION['saleCart'] = $rsProducts;

    $rsCategories = getAllMainCategoriesWithChildren();

    // hideLoginBox - переменная-флаг для того чтобы спрятать блоки
    // логина и регистрации в боковой панели
    if (!isset($_SESSION['user'])) {
        $smarty->assign('hideLoginBox', 1);
    }

    $smarty->assign('pageTitle', 'Заказ');
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProducts', $rsProducts);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'order');
    loadTemplate($smarty, 'footer');
}

/**
 * AJAX функция сохранения зкакза
 *
 * @param array $_SESSION ['saleCart'] массив покупаемых продуктов
 * @return json информация о результате выполнения
 */
function saveorderAction()
{
    // получаем массив покупаемых товаров
    $cart = $_SESSION['saleCart'] ?? null;
    // если корзина пуста, то формируем ответ с ошибкой,
    // отдаем его в формате json и выходим из функции
    if (!$cart) {
        $resData['success'] = 0;
        $resData['message'] = 'Нет товаров для заказа';
        echo json_encode($resData);
        return;
    }

    $name = $_POST['name'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $address = $_POST['address'] ?? null;

    // создаем новый заказ и получаем его ID
    $orderId = makeNewOrder($name, $phone, $address);

    // если заказ не создан, то выдаем ошибку и закрываем функцию
    if (!$orderId) {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка создания заказа';
        echo json_encode($resData);
        return;
    }

    // сохраняем товары для созданого заказа
    $res = setPurchaseForOrder($orderId, $cart);

    // если успешно, то формируем ответ, удалив переменные крзины
    if($res){
        $resData['success'] = 1;
        $resData['message'] = 'Заказ сохранен';
        unset($_SESSION['saleCart']);
        unset($_SESSION['cart']);
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка внесения данных для заказа № ' . $orderId;
    }

    echo json_encode($resData);
}