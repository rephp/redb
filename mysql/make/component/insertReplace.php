<?php

namespace redb\mysql\make\component;

class insertReplace extends insert
{

    protected function parseBody($table)
    {
        $this->partPresqlArr[] = 'INSERT REPLACE INTO `' . $table . '` ';

        return $this;
    }

}