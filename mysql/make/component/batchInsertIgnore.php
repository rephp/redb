<?php
namespace redb\mysql\make\component;

class batchInsertIgnore extends batchInsert
{

    protected function parseBody($table)
    {
        $this->partPresqlArr[] = 'INSERT IGNORE INTO `' . $table . '` ';

        return $this;
    }

}