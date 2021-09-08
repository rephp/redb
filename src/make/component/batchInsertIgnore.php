<?php
namespace redb\make\component;

class batchInsertIgnore extends batchInsert
{

    protected function parseBody($table)
    {
        $this->partPreSqlArr[] = 'INSERT IGNORE INTO `' . $table . '` ';

        return $this;
    }

}