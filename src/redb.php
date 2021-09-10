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
    protected $db='default';
    protected $table;
    protected $config = [];

    use commonTrait;
    use insertTrait;
    use deleteTrait;
    use updateTrait;
    use selectTrait;

    /**
     * 实例化自身对象
     * @return redb
     */
    public static function getClient(array $configList)
    {
        $class = get_called_class();
        return new $class($configList);
    }

    public function __construct(array $configList)
    {
        foreach ($configList as $db => $configArr) {
            //判定$configArr是一维数组还是二维数组
            if (count($configArr) == count($configArr, 1)) {
                $configArr['type'] = 'master';
                $configArr         = [$configArr];
            }
            foreach ($configArr as $config) {
                $config['type'] = strtolower($config['type']);
                $config['type'] == 'master' || $config['type'] = 'slave';
                //如果没有master之前默认一个
                empty($this->config[$db]['master']) && $config['type'] = 'master';
                $this->config[$db][$config['type']][] = [
                    'host'       => $config['host'],
                    'port'       => $config['port'],
                    'username'   => $config['username'],
                    'password'   => $config['password'],
                    'database'   => $config['database'],
                    'charset'    => $config['charset'],
                    'presistent' => $config['presistent'],
                ];
            }
        }
        return $this;
    }

    /**
     * @return cmd
     */
    public function getCmd()
    {
        if (!is_object($this->cmd)) {
            $db = $this->getDb();
            $this->cmd = new cmd($this->config[$db]);
        }
        return $this->cmd;
    }


    /**
     * 获取内核model实例对象
     * @return ormModel
     */
    final private function getOrmModel()
    {
        if (!is_object($this->ormModel)) {
            $this->ormModel = new ormModel();
            $this->ormModel->setTable(self::getTable());
        }
        return $this->ormModel;
    }

    /**
     * 获取当前数据库
     * @return string
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * 获取当前table
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    public function queryRaw($sql)
    {
        return $this->getCmd()->queryRaw($sql);
    }


}