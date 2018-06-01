<?php
/**
 * Created by NeO
 * Date: 01.06.2018
 */

/**
 * Модель для таблицы продукции
 *
 */

/**
 * Внесение в БД продуктов с привязкой к заказу
 *
 * @param integer $orderId ID заказа
 * @param array $cart массив корзины
 * @return boolean TRUE в случае успешного добавления в БД
 */
function setPurchaseForOrder($orderId, $cart)
{
    $query = "INSERT INTO purchase (order_id, product_id, price, amount) VALUES ";

    $values = array();
    // формируем массив строк для запроса для каждого товара
    foreach ($cart as $item) {
        $values[] = "('{$orderId}', '{$item['id']}', '{$item['price']}', '{$item['quantity']}')";
    }

    // преобразование масива в строку
    $query .= implode($values, ', ');
    $builder = new SQLBuilder();
    $rs = $builder->execQuery($query);

    return $rs;
}