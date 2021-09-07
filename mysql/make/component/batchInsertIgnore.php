<?php
namespace redb\mysql\make\component;

class batchInsertIgnore extends batchInsert
{

    protected function parseBody($table)
    {
        $this->bodyPreSql = 'INSERT IGNORE INTO `' . $table . '` ';

        return $this;
    }

}