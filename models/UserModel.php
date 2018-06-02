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
function registerNewUser($email, $passMD5, $name, $phone, $address)
{
    global $connection;
    $email = htmlspecialchars(mysqli_real_escape_string($connection, $email));
    $name = htmlspecialchars(mysqli_real_escape_string($connection, $name));
    $phone = htmlspecialchars(mysqli_real_escape_string($connection, $phone));
    $address = htmlspecialchars(mysqli_real_escape_string($connection, $address));

    $query = "INSERT INTO users(`email`, `pasw`, `name`, `phone`, `address`) 
              VALUES ('{$email}', '{$passMD5}', '{$name}', '{$phone}', '{$address}')";

    $builder = new SQLBuilder();
    $rs = $builder->execQuery($query);

    if ($rs) {
        $query = "SELECT * FROM users WHERE (`email` = '{$email}' AND `pasw` = '{$passMD5}') LIMIT 1";

        $rs = createSmartyRsArray($builder->execQuery($query));

        if (isset($rs[0])) {
            $rs['success'] = 1;
        } else {
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
function checkRegisterParams($email, $pasw1, $pasw2)
{
    $res = null;

    if (!$email) {
        $res['success'] = false;
        $res['message'] = 'Введите email';
    }
    if (!$pasw1) {
        $res['success'] = false;
        $res['message'] = 'Введите пароль';
    }
    if (!$pasw2) {
        $res['success'] = false;
        $res['message'] = 'Введите повтор пароля';
    }
    if ($pasw1 != $pasw2) {
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
function checkUserEmail($email)
{
    global $connection;
    $email = mysqli_real_escape_string($connection, $email);
    $query = "SELECT id FROM users WHERE email = '{$email}'";

    $builder = new SQLBuilder();
    $rs = $builder->execQuery($query);
    $rs = createSmartyRsArray($rs);

    return $rs;
}

/**
 * Авторизация пользователя
 *
 * @param string $email почта (логин)
 * @param string $pass пароль
 * @return array масив данных пользователя
 */
function loginUser($email, $pass)
{
    global $connection;
    $email = htmlspecialchars(mysqli_real_escape_string($connection, $email));
    $pass = md5($pass);

    $query = "SELECT * FROM users WHERE (`email` = '{$email}' AND `pasw` = '{$pass}') LIMIT 1";
    $builder = new SQLBuilder();
    $rs = $builder->execQuery($query);
    $rs = createSmartyRsArray($rs);

    if (isset($rs[0])) {
        $rs['success'] = 1;
    } else {
        $rs['success'] = 0;
    }

    return $rs;
}

/**
 * Изменение данных пользователя
 *
 * @param string $name имя пользователя
 * @param string $phone телефон
 * @param string $address адрес
 * @param string $pass1 новый пароль
 * @param string $pass2 повтор нового пароля
 * @param string $currPass текущий пароль
 * @return boolean TRUE в случае успеха
 */
function updateUserData($name, $phone, $address, $pass1, $pass2, $currPass)
{
    global $connection;
    $email = htmlspecialchars(mysqli_real_escape_string($connection, $_SESSION['user']['email']));
    $name = htmlspecialchars(mysqli_real_escape_string($connection, $name));
    $phone = htmlspecialchars(mysqli_real_escape_string($connection, $phone));
    $address = htmlspecialchars(mysqli_real_escape_string($connection, $address));
    $pass1 = trim($pass1);
    $pass2 = trim($pass2);

    $newPass = null;
    if ($pass1 && ($pass1 == $pass2)) {
        $newPass = md5($pass1);
    }

    $query = "UPDATE users SET ";
    $builder = new SQLBuilder();
//    $builder->table('users');
//    updateWithVerification($builder, 'pasw', $newPass);
//    updateWithVerification($builder, 'name', $name);
//    updateWithVerification($builder, 'phone', $phone);
//    updateWithVerification($builder, 'address', $address);
//    $builder->useAnd()->where("`email` = '{$email}'", "`pasw` = '{$currPass}'");
//    $rs = $builder->exec();

    //------------
    if ($newPass) {
        $query .= "`pasw` = '{$newPass}', ";
    }

    $query .= "`name` = '{$name}',
               `phone` = '{$phone}',
               `address` = '{$address}'
               WHERE `email` = '{$email}' AND `pasw` = '{$currPass}'
               LIMIT 1";

    $rs = $builder->execQuery($query);
    return $rs;
}

/**
 * Функция для изменения одного поля в БД с проверкой на пустоту
 *
 * @param SQLBuilder $builder
 * @param string $field поле таблицы в БД
 * @param string $value значение которое необходимо установить
 * @return SQLBuilder $builder
 */
function updateWithVerification($builder, $field, $value)
{
    if ($value && $value !== '') {
        $builder->update("`{$field}` = '{$value}'");
    }
    return $builder;
}

/**
 * Получить данные заказа текущего пользователя
 *
 * @return array массив заказов с привязкй к продуктам
 */
function getCurUserOrders()
{
    $userId = $_SESSION['user']['id'] ?? 0;
    $rs = getOrdersWithProductsByUser($userId);

    return $rs;
}