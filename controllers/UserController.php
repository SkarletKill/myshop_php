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
    $email = isset($_REQUEST['email'])      ? $_REQUEST['email'] : null;
    $email = trim($email);

    $pasw1 = isset($_REQUEST['pasw1'])      ? $_REQUEST['pasw1'] : null;
    $pasw2 = isset($_REQUEST['pasw2'])      ? $_REQUEST['pasw2'] : null;

    $phone = isset($_REQUEST['phone'])      ? $_REQUEST['phone'] : null;
    $address = isset($_REQUEST['address'])  ? $_REQUEST['address'] : null;
    $name = isset($_REQUEST['name '])       ? $_REQUEST['name '] : null;
    $name = trim($name);


    $resData = null;
    $resData = checkRegisterParams($email, $pasw1, $pasw2);

    if(!$resData && checkUserEmail($email)){
        $resData['success'] = false;
        $resData['message'] = "Пользователь с таким email('{$email}') уже зарегестрирован";
    }

    if(!$resData){
        $passMD5 = md5($pasw1);
        $userData = registerNewUser($email, $passMD5, $name, $phone, $address);

        if($userData['success']){
            $resData['message'] = 'Пользователь успешно зарегестрирован';
            $resData['success'] = 1;

            $userData = $userData[0];
            $resData['userName'] = $userData['name']?? $userData['email'];
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