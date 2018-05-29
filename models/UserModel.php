<?php
/**
 * Created by NeO
 * Date: 29.05.2018
 */

/**
 * Модель для таблицы пользователей
 *
 */

/**
 * Регистрация нового пользователя
 *
 * @param string $email почта
 * @param string $passMD5 пароль зашифрованый в MD5
 * @param string $name имя пользователя
 * @param string $phone телефон
 * @param string $address адрес пользователя
 * @return array массив данных нового пользователя
 */
function registerNewUser($email, $passMD5, $name, $phone, $address){
    global $connection;
    $email   = htmlspecialchars(mysqli_real_escape_string ($connection, $email));
    $name    = htmlspecialchars(mysqli_real_escape_string ($connection, $name));
    $phone   = htmlspecialchars(mysqli_real_escape_string ($connection, $phone));
    $address = htmlspecialchars(mysqli_real_escape_string ($connection, $address));

    $query = "INSERT INTO users(`email`, `pasw`, `name`, `phone`, `address`) 
              VALUES ('{$email}', '{$passMD5}', '{$name}', '{$phone}', '{$address}')";

    $builder = new SQLBuilder();
    $rs = $builder->execQuery($query);

    if($rs){
        $query = "SELECT * FROM users WHERE (`email` = '{$email}' AND `pasw` = '{$passMD5}') LIMIT 1";

        $rs = createSmartyRsArray($builder->execQuery($query));

        if(isset($rs[0])){
            $rs['success'] = 1;
        } else{
            $rs['success'] = 0;
        }
    } else {
        $rs['success'] = 0;
    }

    return $rs;
}

/**
 * Проверка параметров для регистрацмм пользователя
 *
 * @param string $email email
 * @param string $pasw1 пароль
 * @param string $pasw2 повтор пароля
 * @return array результат
 */
function checkRegisterParams($email, $pasw1, $pasw2){
    $res = null;

    if(!$email){
        $res['success'] = false;
        $res['message'] = 'Введите email';
    }
    if(!$pasw1){
        $res['success'] = false;
        $res['message'] = 'Введите пароль';
    }
    if(!$pasw2){
        $res['success'] = false;
        $res['message'] = 'Введите повтор пароля';
    }
    if($pasw1 != $pasw2){
        $res['success'] = false;
        $res['message'] = 'Пароли не совпадают';
    }

    return $res;
}

/**
 * Проверка почты (есть ли email адрес в БД)
 *
 * @param string $email
 * @return array строка из таблицы users | null
 */
function checkUserEmail($email){
    global $connection;
    $email = mysqli_real_escape_string($connection, $email);
    $query = "SELECT id FROM users WHERE email = '{$email}'";

    $builder = new SQLBuilder();
    $rs = $builder->execQuery($query);
    $rs = createSmartyRsArray($rs);

    return $rs;
}