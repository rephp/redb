<?php
namespace database\mysql\traits;

use database\mysql\console\coreModel;

trait commonTrait
{
    protected $client = [];

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

    /**
     * 实例化自身对象
     * @return \database\mysql\mysql
     */
    public static function db()
    {
        return new self();
    }

    /**
     * 获取内核model实例对象
     * @return Model
     */
    public function getCoreModel()
    {
        if(!is_object($this->coreModel)){
            $this->coreModel = new coreModel();
        }
        return $this->coreModel;
    }


    public function close(){
        return $this->getCoreModel()->close();
    }

    public function run()
    {
        return $this->getCoreModel()->run();
    }


    //update|select|delete
    public function where($where)
    {

    }

    public function orWhere($where)
    {

    }

    /**
     * 左括号
     */
    public function leftBracket()
    {

    }

    /**
     * 右边括号
     */
    public function rightBracket()
    {

    }

    //insert|update
    public function data()
    {

    }

    public function getSql()
    {
        return $this->getCoreModel()->getSql();
    }

    protected function log()
    {

    }

}
