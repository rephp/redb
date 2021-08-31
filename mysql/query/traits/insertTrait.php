<?php
namespace redb\mysql\query\traits;

use redb\mysql\query\log;

trait insertTrait
{

    public function insert()
    {
        $startTime = microtime(true);
        //todo:something
        //...
        log::setLog($sql, round(microtime(true) - $startTime, 6) . 'S');

        return $result;
    }

    public function insertReplace()
    {
        $startTime = microtime(true);
        //todo:something
        //...
        log::setLog($sql, round(microtime(true) - $startTime, 6) . 'S');

        return $result;
    }

    public function insertIgnore()
    {
        $startTime = microtime(true);
        //todo:something
        //...
        log::setLog($sql, round(microtime(true) - $startTime, 6) . 'S');

        return $result;
    }

}