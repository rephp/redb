<?php

namespace redb\make\component;

class insertReplace extends insert
{

    protected function parseBody($table)
    {
        $this->partPreSqlArr[] = 'INSERT REPLACE INTO `' . $table . '` ';

        return $this;
    }

}