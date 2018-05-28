<?php
/**
 * Created by NeO
 * Date: 23.05.2018
 */

/**
 *
 * Файл настроек
 *
 */

//constants to access the controller
define('PathPrefix', '../controllers/');
define('PathPostfix', 'Controller.php');

//> template
$template = 'default';

//пути к файлам шаблона
define('TemplatePrefix', "../views/{$template}/");
define('TemplatePostfix', ".tpl");

//пути к файлам шаблонов в вебпространстве
define('TemplateWebPath', "templates/{$template}/");
//<

//> Инициализация шаблонизатора Smarty
//put full path to Smarty.class.php
require('../library/Smarty/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir(TemplatePrefix);
$smarty->setCompileDir('../tmp/smarty/templates_c');
$smarty->setCacheDir('../tmp/smarty/cache');
$smarty->setConfigDir('../library/Smarty/configs');

$smarty->assign('templateWebPath', TemplateWebPath);
//<