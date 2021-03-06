<?php
/**
 * Created by NeO
 * Date: 01.06.2018
 */

/**
 * Модель для таблицы заказов (Orders)
 *
 */

/**
 * Создание заказа (без привязки товара)
 *
 * @param string $name
 * @param string $phone
 * @param string $address
 * @return integer ID созданного заказа
 */
function makeNewOrder($name, $phone, $address)
{
    //> инициализация переменных
    $userId = $_SESSION['user']['id'];
    $comment = "id пользователя: {$userId}<br/>
                Имя: {$name}
                Тел: {$phone}
                Адрес: {$address}";

    $dateCreated = date('Y.m.d H:i:s');
    $userIp = $_SERVER['REMOTE_ADDR'];
    //<

    $query = "INSERT INTO `orders` 
            (`user_id`, `date_created`, `date_payment`, `status`, `comment`, `user_ip`)
            VALUES ('{$userId}', '{$dateCreated}', null, '0', '{$comment}', '{$userIp}')";

    $builder = new SQLBuilder();
    $rs = $builder->execQuery($query);

    // получить ID созданного заказа
    if ($rs) {
        $query = "SELECT id FROM orders ORDER BY id DESC LIMIT 1";
        $rs = $builder->execQuery($query);
        $rs = createSmartyRsArray($rs);

        // возвращаем ID созданного запроса
        if (isset($rs[0])) {
            return $rs[0]['id'];
        }
    }
}

/**
 * Получить список заказов с привязкой к продуктам для пользователя с $userId
 *
 * @param integer $userId ID пользователя
 * @return array массив заказов с привязкой к продуктам
 */
function getOrdersWithProductsByUser($userId)
{
    $userId = intval($userId);
    $query = "SELECT * FROM orders WHERE `user_id` = '{$userId}' ORDER BY id DESC";

    $builder = new SQLBuilder();
    $rs = $builder->execQuery($query);

    $smartyRs = array();
    while ($row = $rs->fetch()) {
        $rsChildren = getPurchaseForOrder($row['id']);

        if ($rsChildren) {
            $row['children'] = $rsChildren;
            $smartyRs[] = $row;
        }
    }

    return $smartyRs;
}