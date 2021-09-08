<?php
namespace redb\mysql\make\component;

class insertIgnore extends insert
{

    protected function parseBody($table)
    {
        $this->partPresqlArr[] = 'INSERT IGNORE INTO `' . $table . '` ';

        return $this;
    }

}