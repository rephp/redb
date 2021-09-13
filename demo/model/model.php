<?php

namespace demo\model;

use rephp\redb\redb;

class model extends redb
{
    public static function db(array $configList = [])
    {
        //这里是模拟系统函数，自动获取系统数据库整体配置,本demo因为没运行在框架或者应用实例中，所以暂时先注销，正式使用时建议开启
        //empty($configList) && $configList = config('database');
        return self::getClient($configList);
    }

}