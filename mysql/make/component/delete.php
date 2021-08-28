<?php
namespace redb\mysql\make\component;
use redb\mysql\lib\lib;

class delete
{

    public function deal($where, $table, $db)
    {

    }

    /**
     * 生成删除presql语句
     * @param array  $where 查询条件
     * @param string $table 表名
     * @return string
     */
    public function getPreSql($where, $table)
    {
        $preSql      = 'DELETE FROM `' . $table . '` ';
        $wherePreSql = lib::formatWherePreSql($where);
        empty($wherePreSql) || $preSql .= ' WHERE ' . $wherePreSql;

        return $preSql;
    }

    public function getPreParams($where)
    {
        return lib::formatPreSqlParams($where);
    }

}