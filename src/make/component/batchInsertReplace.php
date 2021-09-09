<?php

namespace rephp\redb\make\component;

class batchInsertReplace extends batchInsert
{

    protected function parseBody($table)
    {
        $this->partPreSqlArr[] = 'INSERT REPLACE INTO `' . $table . '` ';

        return $this;
    }

}