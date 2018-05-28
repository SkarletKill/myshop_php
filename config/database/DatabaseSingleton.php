<?php
/**
 * Created by NeO
 * Date: 12.04.2018
 */

//PDO WRAPPER (Singleton)

class Database extends PDO
{
    protected static $instance = null;

    public function __construct($dsn, $username, $passwd, $options){
        parent::__construct($dsn, $username, $passwd, $options);
    }

    private function __clone()
    {
    }

    public static function instance()
    {
        if (self::$instance === null) {
            $opt = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            );
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;
            self::$instance = new self($dsn, DB_USER, DB_PASS, $opt);
        }
        return self::$instance;
    }

    public static function __callStatic($method, $args)
    {
        return call_user_func_array(array(self::instance(), $method), $args);
    }

    public static function run($sql, $args = [])
    {
        $stmt = self::instance()->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }

    public static function sql($placeholder_type, $statement, $values = [])
    {
        $stmt = null;
        if (strtolower($placeholder_type) == 'nominal') {
            $args = [];
            foreach ($values as $str) {
                $args = array_merge($args, $str);
            }
            $stmt = Database::run($statement, $args);
        } else if (strtolower($placeholder_type) == 'positional' or strtolower($placeholder_type) == 'nameless') {
            $stmt = Database::run($statement, $values);
        }
        return $stmt;
    }

    public static function dsql($placeholder_type, $statement, $values = [])
    {
        $stmt = null;
        if (strtolower($placeholder_type) == 'nominal') {
            $args = [];
            foreach ($values as $str) {
                $args = array_merge($args, $str);
            }
            $stmt = Database::run($statement, $args);
        } else if (strtolower($placeholder_type) == 'positional' or strtolower($placeholder_type) == 'nameless') {
            $stmt = Database::run($statement, $values);
        }
        echo 'statement: '. htmlspecialchars(self::getFullQuery($placeholder_type, $stmt, $statement, $values));
        return $stmt;
    }

    public static function getFullQuery($placeholder_type, $stm, $query_statement, $query_parameters) {
        if (strtolower($placeholder_type) == 'positional' or strtolower($placeholder_type) == 'nameless') {
            $parameter_count = count($query_parameters);
            $copy = $query_statement;
            $from = '/'.preg_quote('?', '/').'/';
            $replace_count = 1;
            for ($i = 0; $i < $parameter_count; $i++) {
                $copy = preg_replace($from, $query_parameters[$i], $copy, $replace_count);
            }
            return $copy;
        }
        if (strtolower($placeholder_type) == 'nominal') {
            $copy = $query_statement;
            var_dump($copy);
            foreach ($query_parameters as $key => $value) {
                $copy = str_replace(":$key", $query_parameters[$key], $copy);
            }
            return $copy;
        }
        return $stm->queryString;
    }
}