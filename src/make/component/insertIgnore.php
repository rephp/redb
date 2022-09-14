<?php

namespace rephp\redb\make\component;

/**
 * 生成单条忽略式插入sql
 * @package rephp\redb\make\component
 */
class insertIgnore extends insert
{
    /**
     * 解析sql主体
     * @param string $table  数据表名字
     * @return $this
     */
    protected function parseBody($table)
    {
        $this->partPreSqlArr[] = 'INSERT IGNORE INTO `' . $table . '` ';

        return $this;
    }
}
