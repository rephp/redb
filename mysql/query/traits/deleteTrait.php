<?php
namespace redb\mysql\query\traits;

use redb\mysql\query\log;

trait deleteTrait
{

    public function delete($sql)
    {
        $startTime = microtime(true);
        //todo:something
        //...
        log::setLog($sql, round(microtime(true) - $startTime, 6) . 'S');

        return $result;
    }

}