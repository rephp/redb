<?php
namespace redb\make\component;

class insertIgnore extends insert
{

    protected function parseBody($table)
    {
        $this->partPreSqlArr[] = 'INSERT IGNORE INTO `' . $table . '` ';

        return $this;
    }

}