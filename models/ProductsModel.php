<?php
/**
 * Created by NeO
 * Date: 26.05.2018
 */

/**
 * Модель для таблицы продукции
 *
 */

/**
 * Получить последние добавленные товары
 *
 * @param integer $limit ограничение количества товаров
 * @return array Массив товаров
 */
function getLastProducts($limit = null){
    $query = "SELECT * FROM `products` ORDER BY id DESC";

    if($limit){
        $query .= " LIMIT {$limit}";
    }

    $builder = new SQLBuilder();
    $rs = $builder->execQuery($query);

    return createSmartyRsArray($rs);
}

/**
 * Получить продукты для категории $itemId
 *
 * @param integer $itemId ID категории
 * @return array массив продуктов
 */
function getProductsByCategory($itemId){
    $itemId = intval($itemId);
    $query = "SELECT * FROM products WHERE category_id = '{$itemId}'";

    $builder = new SQLBuilder();
    $rs = $builder->execQuery($query);

    return createSmartyRsArray($rs);
}

/**
 * Получить данные продукта по ID
 *
 * @param integer $itemId ID продукта
 * @return array масив данных продукта
 */
function getProductById($itemId){
    $itemId = intval($itemId);
    $query = "SELECT * FROM products WHERE id = '{$itemId}'";

    $builer = new SQLBuilder();
    $rs = $builer->execQuery($query);
    return $rs->fetch();
}