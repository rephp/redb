<?php
namespace redb\mysql\query\traits;

use redb\mysql\query\log;

trait updateTrait
{

    public function update()
    {
        $startTime = microtime(true);
        //todo:something
        //...
        log::setLog($sql, round(microtime(true) - $startTime, 6) . 'S');

        return $result;
    }

}