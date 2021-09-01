<?php
namespace redb\mysql;

use redb\mysql\traits\commonTrait;
use redb\mysql\traits\selectTrait;
use redb\mysql\query\cmd;
use redb\mysql\traits\insertTrait;
use redb\mysql\traits\deleteTrait;
use redb\mysql\traits\updateTrait;
use redb\mysql\orm\ormModel;

/**
 * Class mysql
 * @package redb\mysql
 */
class mysql
{
    /**
     * model内核
     * @var \redb\mysql\ormModel $ormModel
     */
    protected $ormModel;

    use commonTrait;
    use insertTrait;
    use deleteTrait;
    use updateTrait;
    use selectTrait;

    /**
     * 实例化自身对象
     * @return \database\mysql\mysql
     */
    public static function db()
    {
        return new self();
    }

    /**
     * @return cmd
     */
    public function getCmd()
    {
        if(!is_object($this->cmd)){
            $this->cmd = new cmd();
        }
        return $this->cmd;
    }


    /**
     * 获取内核model实例对象
     * @return \redb\mysql\orm\ormModel $this->ormModel
     */
    final private function getOrmModel()
    {
        if(!is_object($this->ormModel)){
            $this->ormModel = new ormModel();
        }
        return $this->ormModel;
    }

    /**
     * 获取当前数据库
     * @return Db
     */
    public static function getDb()
    {
        return self::$db;
    }

    /**
     * 获取当前table
     * @return Db
     */
    public static function getTable()
    {
        return self::$table;
    }


}