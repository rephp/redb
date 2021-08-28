<?php

namespace  redb\mysql\console;

class log
{
    public static $history = [];

    /**
     * 获取历史以来执行的sql
     */
    public function getLog()
    {
        return self::$history;
    }

    /**
     * 记录日志
     * @param string $sql
     * @param int    $time
     * @return array
     */
    public function setLog($sql, $time = 0)
    {
        return self::$history[] = [$time => $sql];
    }

}