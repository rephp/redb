<?php

namespace rephp\redb\make\component;
/**
 * 生成单条替换式插入sql
 * @package rephp\redb\make\component
 */
class insertReplace extends insert
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