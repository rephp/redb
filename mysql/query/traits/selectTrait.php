<?php
namespace redb\mysql\query\traits;

use redb\mysql\query\log;

trait selectTrait
{

    public function one()
    {
        $startTime = microtime(true);
        //todo:something
        //...
        log::setLog($sql, round(microtime(true) - $startTime, 6) . 'S');

        return $result;
    }

    public function all()
    {
        $startTime = microtime(true);
        //todo:something
        //...
        log::setLog($sql, round(microtime(true) - $startTime, 6) . 'S');

        return $result;
    }

    public function count()
    {
        $startTime = microtime(true);
        //todo:something
        //...
        log::setLog($sql, round(microtime(true) - $startTime, 6) . 'S');

        return $result;
    }
}