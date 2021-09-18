<?php

namespace demo\model;

use rephp\redb\redb;

class model extends redb
{
    /**
     * 初始化模型，参数按照model设定的db传参给redb
     */
    public function __construct($configList = [])
    {
        //todo:在用户自己的框架中实现对配置项的读写，故而这里暂时注释
        //empty($configList) && $configList = config('database');
        //获取数据库配置
        $db = $this->getDb();
        if (!isset($configList[$db])) {
            throw new \Exception('2当前模型db配置错误，请检查数据库配置项的key', 1404);
        }
        parent::__construct($configList[$db]);
    }

    /**
     * 静态方法获取动态对象
     * 如果实现__construct方法的自实例化参数加载，即当前demo中注释的第15行：empty($configList) || $configList = config('database');
     * 生效后即可不传递参数而调用本方法
     * 参数按照model设定的db传参实例化redb
     * @param array $configList
     * @return redb
     */
    public static function db($configList = [])
    {
        return parent::db($configList);
    }

}