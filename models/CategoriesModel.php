<?php
/**
 * Created by NeO
 * Date: 24.05.2018
 */

/**
 * Модель таблицы категорий (categories)
 *
 */

require_once "../config/database/SQLBuilder.php";

/**
 * Получить дочерние категории для $categotyID
 *
 * @param integer $categoryID ID категории
 * @return array массив дочерних категорий
 */
function getChildrenForCategory($categoryID)
{
    $query = "SELECT * FROM categories WHERE parrent_id = $categoryID";

    $builder = new SQLBuilder();
//    $rs = $builder->table("categories")->select()->where("parrent_id = $categoryID")->getQuery()->exec();
    $rs = $builder->execQuery($query);

    return createSmartyRsArray($rs);
}

/**
 * Получить главные категории с привязками дочерних
 *
 * @return array масив категорий
 */
function getAllMainCategoriesWithChildren()
{
    $query = 'SELECT * FROM categories WHERE parrent_id = 0';

    $builder = new SQLBuilder();
//    $rs = $builder->table("categories")->select()->where('parrent_id = 0')->getQuery()->exec();
    $rs = $builder->execQuery($query);

    $smarty_rs = array();
    while ($row = $rs->fetch()) {
        $rsChildren = getChildrenForCategory($row['id']);

        if ($rsChildren) {
            $row['children'] = $rsChildren;
        }
        $smarty_rs[] = $row;
    }

    return $smarty_rs;
}

/**
 * Получить данные категории по id
 *
 * @param integer $categoryID ID категории
 * @return array массив - строка категорий
 */
function getCategoryById($categoryID)
{
    $categoryID = intVal($categoryID);
    $query = "SELECT * FROM categories WHERE id = '{$categoryID}'";

    $builder = new SQLBuilder();
    $rs = $builder->execQuery($query);

    return $rs->fetch();
}