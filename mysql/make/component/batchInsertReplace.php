<?php

namespace redb\mysql\make\component;

class batchInsertReplace extends batchInsert
{

    protected function parseBody($table)
    {
        $this->partPresqlArr[] = 'INSERT REPLACE INTO `' . $table . '` ';

        return $this;
    }

}