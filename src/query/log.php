<?php

namespace redb\query;

class log
{
    public static $history = [];
    public static $error   = [];

    /**
     * 获取历史以来执行的sql
     */
    public static function getLog()
    {
        return self::$history;
    }

    /**
     * 记录日志
     * @param string $sql
     * @param int    $time
     * @return array
     */
    public static function setLog($sql, $time = 0)
    {
        return self::$history[] = ['time' => $time, 'sql' => $sql];
    }

    public static function setErrorLog($sql, $time = 0, $extErrorInfo)
    {
        return self::$error[] = ['time' => $time, 'sql' => $sql, 'error' => $extErrorInfo];
    }

}