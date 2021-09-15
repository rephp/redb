<?php

namespace rephp\redb\make\component;

class insertReplace extends insert
{

    protected function parseBody($table)
    {
        $this->partPreSqlArr[] = 'REPLACE INTO `' . $table . '` ';

        return $this;
    }

}