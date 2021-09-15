<?php

namespace rephp\redb\make\component;

class batchInsertReplace extends batchInsert
{

    protected function parseBody($table)
    {
        $this->partPreSqlArr[] = 'REPLACE INTO `' . $table . '` ';

        return $this;
    }

}