<?php
/**
 * Created by NeO
 * Date: 24.05.2018
 */

/**
 * Инициализация подключения к БД
 *
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'myshop');
define('DB_USER', 'root');
define('DB_PASS', 'H0LL0W');
define('DB_CHAR', 'utf8');

require_once "database/SQLBuilder.php";
//$builder = new SQLBuilder();
