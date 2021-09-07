<?php

namespace redb\mysql\make\component;

class batchInsertReplace extends batchInsert
{

    protected function parseBody($table)
    {
        $this->bodyPreSql = 'INSERT REPLACE INTO `' . $table . '` ';

        return $this;
    }

}