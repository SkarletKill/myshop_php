<?php
/**
 * Created by PhpStorm.
 * User: NeO
 * Date: 12.04.2018
 * Time: 0:49
 */

require "DatabaseSingleton.php";

class SQLBuilder
{
    private $db = null;
    private $table_name = null;
    private $joined_tables = null;
    private $query = null;
    private $concatenator = " AND ";

    private $sel = false;
    private $ins = false;
    private $upd = false;
    private $del = false;

    private $where = false;
    private $ordBy = false;

    private $query_parameters = array();
    private $select_parameters = '*';
    private $insert_parameters = array();
    private $insert_fields = null;
    private $update_parameters = '';
    private $where_parameters = null;
    private $ordBy_parameters = null;

    public function __construct()
    {
        $this->db = Database::instance();
    }

    private function clearBooleans()
    {
        $this->ins = false;
        $this->upd = false;
        $this->del = false;
        $this->sel = false;
    }

    private function checkBooleans()
    {
        return $this->ins and $this->upd and $this->del and $this->sel;
    }

    private function addScope($values)
    {
        $val2 = $values;
        for ($i = 0; $i < count($values); $i++) {
            if (!is_string($values[$i]))
                $val2[$i] = strval($values[$i]);
        }
        var_dump($val2);
        return $val2;
    }

    public function table($table_name)
    {
        $this->table_name = $table_name;
        return $this;
    }

    public function insertFields(...$values)
    {
        if ($values == null) return $this;
        $this->clearBooleans();
        $this->ins = true;
        $values = $this->addScope($values);
        $parameters_inline = implode(", ", $values);
        $this->insert_fields = $parameters_inline;      //need adds - '('.$params.')'
//        $this->query_parameters = $values;
        return $this;
    }

    public function insert(...$values)
    {
        if ($values == null) return $this;
        $this->clearBooleans();
        $this->ins = true;
//        $values = $this->addScope($values);
        $this->insert_parameters = $values;      //need adds - '('.$params.')'
        return $this;
    }

    public function update(...$values)
    {
        if ($values == null) return $this;
        $this->clearBooleans();
        $this->upd = true;
        $values = $this->addScope($values);
        $parameters_inline = implode(", ", $values);
        $this->update_parameters .= ($this->update_parameters == '') ? $parameters_inline : ', ' . $parameters_inline;
        return $this;
    }

    public function delete()
    {
        $this->clearBooleans();
        $this->del = true;
        return $this;
    }

    public function select(...$values)
    {
        if ($values == null) {
            $this->clearBooleans();
            $this->sel = true;
            return $this;
        }
        $this->clearBooleans();
        $this->sel = true;
        $parameters_inline = implode(", ", $values);
        $this->select_parameters = $parameters_inline;
        return $this;
    }

    public function where(...$values)
    {
        if ($values == null) return $this;
        $this->where = true;
        $parameters_inline = implode($this->concatenator, $values);
        $this->where_parameters = $parameters_inline;
        return $this;
    }

    public function useAnd()
    {
        $this->concatenator = " AND ";
        return $this;
    }

    public function useOR()
    {
        $this->concatenator = " OR ";
        return $this;
    }

    public function orderBy(...$values)
    {
        if ($values == null) return $this;
        $this->ordBy = true;
        $parameters_inline = implode(", ", $values);
        $this->ordBy_parameters = $parameters_inline;
        return $this;
    }

    public function join($nextTable)
    {
        $this->joined_tables = $this->table_name . ' JOIN ' . $nextTable;
        return $this;
    }

    public function getQuery()
    {
        if ($this->table_name === null) return $this;
        if (!$this->checkBooleans()) $this->sel = true;

        if ($this->ins) {
            $this->query = "INSERT " . "INTO " . $this->table_name;
            if ($this->insert_fields != null) {
                $this->query = $this->query . "(" . $this->insert_fields . ")";
            }
            $this->query = $this->query . " VALUES(";
            $placeholders = '';
            for ($i = 0; $i < count($this->insert_parameters); $i++) {
                $placeholders = $placeholders . '?,';
            }
            $placeholders = trim($placeholders, ',');
            $this->query = $this->query . $placeholders . ")";
            $this->query_parameters = $this->insert_parameters;
        } elseif ($this->upd) {
            $this->query = 'UPDATE ' . $this->table_name . ' SET ' . $this->update_parameters;
            if ($this->where) {
                $this->query = $this->query . ' WHERE ' . $this->where_parameters;
            }
        } elseif ($this->del) {
            $this->query = 'DELETE ' . 'FROM ' . $this->table_name;
            if ($this->where) {
                $this->query = $this->query . ' WHERE ' . $this->where_parameters;
            }
        } elseif ($this->sel) {
            $this->query = 'SELECT ' . $this->select_parameters . ' FROM ';
            if ($this->joined_tables != null) {
                $this->query = $this->query . $this->joined_tables;
            } else {
                $this->query = $this->query . $this->table_name;
            }

            if ($this->where) {
                $this->query = $this->query . ' WHERE ' . $this->where_parameters;
            }
            if ($this->ordBy) {
                $this->query = $this->query . ' ORDER BY ' . $this->ordBy_parameters;
            }
        }

        return $this;
    }

    public function get()
    {
        $this->query = 'SELECT ' . '*' . ' FROM ' . $this->table_name;
        $stmt = $this->exec();              //need variable to assignment
        return $stmt;
    }

    public function exec($debug = false)
    {
//        $this->getQuery();
        $stmt = null;
        if ($debug == true) {
            if (empty($this->query_parameters))
                $stmt = $this->db->dsql('positional', $this->query);
            else
                $stmt = $this->db->dsql('positional', $this->query, $this->query_parameters);
        } else if ($debug == false) {
            if (empty($this->query_parameters))
                $stmt = $this->db->sql('positional', $this->query);
            else
                $stmt = $this->db->sql('positional', $this->query, $this->query_parameters);
        }
        return $stmt;
    }

    public function execQuery($localQuery)
    {
        if (empty($this->query_parameters))
            $stmt = $this->db->sql('positional', $localQuery);
        else
            $stmt = $this->db->sql('positional', $localQuery, $this->query_parameters);

        return $stmt;
    }

    public function printQuery()
    {
        var_dump($this->query);
        return $this;
    }
}