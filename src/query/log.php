<?php

namespace rephp\redb\query;

/**
 * 日志记录
 * @package rephp\redb\query
 */
class log
{
    public static $history = [];
    public static $error   = [];

    /**
     * 获取历史以来执行的sql
     */
    public static function getAllLog()
    {
        return self::$history;
    }

    /**
     * 获取最近一条执行信息
     * @return mixed
     */
    public static function getLastLog()
    {
        return end(self::$history);
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

    /**
     * 设置一条执行错误信息
     * @param string $sql          sql语句
     * @param float  $time         执行时间
     * @param mixed  $extErrorInfo 错误信息
     * @return array
     */
    public static function setErrorLog($sql, $time = 0, $extErrorInfo)
    {
        return self::$error[] = ['time' => $time, 'sql' => $sql, 'error' => $extErrorInfo];
    }

    /**
     * 获取最近一条执行错误信息
     * @return mixed
     */
    public static function getLastErrorLog()
    {
        return end(self::$error);
    }


}