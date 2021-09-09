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
    protected $db;
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
    public static function db()
    {
        $class = get_called_class();
        return new $class();
    }

    public function setConnect($type = 'master', $host = '127.0.0.1', $port = 3389, $username = '', $password = '', $database = '', $charset = 'utf8', $presistent = false)
    {
        $type = strtolower($type);
        $type=='master' || $type = 'slave';
        $this->config[$type][] = [
            'host'       => $host,
            'port'       => $port,
            'username'   => $username,
            'password'   => $password,
            'database'   => $database,
            'charset'    => $charset,
            'presistent' => $presistent,
        ];
        return $this;
    }

    /**
     * @return cmd
     */
    public function getCmd()
    {
        if (!is_object($this->cmd)) {
            $this->cmd = new cmd($this->config);
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