<?php

namespace redb\mysql\make\component;

class insertReplace extends insert
{

    protected function parseBody($table)
    {
        $this->bodyPreSql = 'INSERT REPLACE INTO `' . $table . '` ';

        return $this;
    }

}