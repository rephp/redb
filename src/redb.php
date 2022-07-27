<?php

namespace rephp\redb;

use rephp\redb\traits\commonTrait;
use rephp\redb\traits\selectTrait;
use rephp\redb\query\cmd;
use rephp\redb\traits\insertTrait;
use rephp\redb\traits\deleteTrait;
use rephp\redb\traits\updateTrait;
use rephp\redb\orm\ormModel;

class redb
{
    /**
     * model内核
     * @var \rephp\redb\orm\ormModel $ormModel
     */
    protected $ormModel;
    protected static $db = 'default';
    protected static $table;
    protected $config = [];

    use commonTrait;
    use insertTrait;
    use deleteTrait;
    use updateTrait;
    use selectTrait;

    /**
     * redb 初始化配置项
     * @param array $configList
     * @return object
     */
    public function __construct(array $configList)
    {
        //兼容一维数组配置
        if (count($configList) == count($configList, 1)) {
            $configList = [$configList];
        }
        foreach ($configList as $config) {
            $config['type'] = strtolower($config['type']);
            $config['type'] == 'master' || $config['type'] = 'slave';
            //如果没有master之前默认一个
            empty($this->config['master']) && $config['type'] = 'master';
            $this->config[$config['type']][] = $config;
        }
    }

    /**
     * 获取sql执行者
     * @return cmd
     */
    public function getCmd()
    {
        is_object($this->cmd) || $this->cmd = new cmd($this->config);
        return $this->cmd;
    }


    /**
     * 获取orm model实例对象
     * @return ormModel
     */
    final protected function getOrmModel()
    {
        is_object($this->ormModel) || $this->ormModel = (new ormModel())->setTable(self::getTableName());
        return $this->ormModel;
    }

    /**
     * 设置orm实例对象
     * @return $this
     */
    final protected function setOrmModel(ormModel $ormModel)
    {
        $this->ormModel = $ormModel;
        return $this;
    }

    /**
     * 获取当前model中设置的数据库配置key
     * @return string
     */
    public static function getDb()
    {
        $class = get_called_class();
        return $class::$db;
    }

    /**
     * 获取当前table名字
     * @return string
     */
    public static function getTableName()
    {
        $class = get_called_class();
        return $class::$table;
    }

    /**
     * 执行用户自定义sql
     * @param string  $sql  真正sql语句
     * @return bool
     */
    public function queryRaw($sql)
    {
        return $this->getCmd()->queryRaw($sql);
    }
}
