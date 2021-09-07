<?php
namespace redb\mysql\make\component;

class insertIgnore extends insert
{

    protected function parseBody($table)
    {
        $this->bodyPreSql = 'INSERT IGNORE INTO `' . $table . '` ';

        return $this;
    }

}