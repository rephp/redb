<?php

namespace rephp\redb\make\component;
/**
 * 生成替换式批量插入sql
 * @package rephp\redb\make\component
 */
class batchInsertReplace extends batchInsert
{

    /**
     * 解析sql主体
     * @param string $table  数据表名字
     * @return $this
     */
    protected function parseBody($table)
    {
        $this->partPreSqlArr[] = 'REPLACE INTO `' . $table . '` ';

        return $this;
    }

}