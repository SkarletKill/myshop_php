<?php
/**
 * Created by NeO
 * Date: 29.05.2018
 */

/**
 * Контроллер функций пользователя
 *
 */

//подключаем модели
include_once '../models/CategoriesModel.php';
include_once '../models/UserModel.php';

/**
 * AJAX регистрация пользователя
 * Инициализация сессионной переменной ($_SESSION['user'})
 *
 * @return json масив данных нового пользователя
 */
function registerAction()
{
//    $email = isset($_REQUEST['email'])      ? $_REQUEST['email'] : null;
    $email = $_REQUEST['email'] ?? null;     //equivalent
    $email = trim($email);

    $pasw1 = $_REQUEST['pasw1'] ?? null;
    $pasw2 = $_REQUEST['pasw2'] ?? null;

    $phone = $_REQUEST['phone'] ?? null;
    $address = $_REQUEST['address'] ?? null;
    $name = $_REQUEST['name '] ?? null;
    $name = trim($name);


    $resData = null;
    $resData = checkRegisterParams($email, $pasw1, $pasw2);

    if (!$resData && checkUserEmail($email)) {
        $resData['success'] = false;
        $resData['message'] = "Пользователь с таким email('{$email}') уже зарегестрирован";
    }

    if (!$resData) {
        $passMD5 = md5($pasw1);
        $userData = registerNewUser($email, $passMD5, $name, $phone, $address);

        if ($userData['success']) {
            $resData['message'] = 'Пользователь успешно зарегестрирован';
            $resData['success'] = 1;

            $userData = $userData[0];
            $resData['userName'] = $userData['name'] ? $userData['name'] : $userData['email'];
            $resData['userEmail'] = $email;

            $_SESSION['user'] = $userData;
            $_SESSION['user']['displayName'] = $resData['userName'];
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка регистрации';
        }
    }

    echo json_encode($resData);
}

/**
 * Разлогинивание пользователя
 *
 */
function logoutAction()
{
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
        unset($_SESSION['cart']);
    }

    redirect('/');
}

/**
 * AJAX авторизация пользователя
 *
 * @return json
 */
function loginAction()
{
    $email = $_REQUEST['email'] ?? null;
    $email = trim($email);

    $pass = $_REQUEST['pasw'] ?? null;
    $pass = trim($pass);

    $userData = loginUser($email, $pass);

    if ($userData['success']) {
        $userData = $userData[0];

        $_SESSION['user'] = $userData;
        $_SESSION['user']['displayName'] = $userData['name'] ? $userData['name'] : $userData['email'];

        $resData = $_SESSION['user'];
        $resData['success'] = 1;


    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Неправильний логін чи пароль';
    }

    echo json_encode($resData);
}

/**
 * Формирование главной страницы пользователя
 *
 * @link /user/
 * @param object $smarty шаблонизатор
 */
function indexAction($smarty)
{
    //если пользователь не залогинен, то редирект на главную страницу
    if (!isset($_SESSION['user'])) {
        redirect('/');
    }

    //получаем список категорий для меню
    $rsCategories = getAllMainCategoriesWithChildren();

    $smarty->assign('pageTitle', 'Страница пользователя');
    $smarty->assign('rsCategories', $rsCategories);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'user');
    loadTemplate($smarty, 'footer');
}

/**
 * Обновление данных пользователя
 *
 * @return boolean, json результаты выполнения функции
 */
function updateAction()
{
    //> если пользователь не залогинен, то выходим
    if (!isset ($_SESSION['user'])) {
        redirect('/');
    }
    //<

    //> инициализация переменных (данных о пользователе)
    $resData = array();
    $name = $_REQUEST['name'] ?? null;       //need change to $_POST['name']?? null;
    $phone = $_REQUEST['phone'] ?? null;
    $address = $_REQUEST['address'] ?? null;
    $pass1 = $_REQUEST['pass1'] ?? null;
    $pass2 = $_REQUEST['pass2'] ?? null;
    $currPass = $_REQUEST['currPass'] ?? null;
    //<

    // проверка правильности пароля
    $currPassMD5 = md5($currPass);
    if (!$currPass || ($_SESSION['user']['pasw'] != $currPassMD5)) {
        $resData['success'] = 0;
        $resData['message'] = 'Текущий пароль не верный';
        echo json_encode($resData);
        return false;
    }

    //
    $res = updateUserData($name, $phone, $address, $pass1, $pass2, $currPassMD5);
    if ($res) {
        $resData['success'] = 1;
        $resData['message'] = 'Данные сохранены';
        $resData['userName'] = $name;

        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['address'] = $address;

        if ($pass1 && ($pass1 == $pass2)) {
            $_SESSION['user']['pasw'] = md5(trim($pass1));
        }

        $_SESSION['user']['displayName'] = $name ? $name : $_SESSION['user']['email'];
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка сохранения данных';
    }

    echo json_encode($resData);
    return true;
}