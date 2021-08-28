<?php
namespace redb\mysql\traits;

use redb\mysql\console\coreModel;

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

    public function close(){
        return $this->getCmd()->close();
    }

    public function run()
    {
        return $this->getCmd()->setModel($this->getCoreModel())->run();
    }


    //update|select|delete
    public function where($where)
    {
        $this->getCoreModel()->where($where);
        return $this;
    }

    public function orWhere($where)
    {
        $this->getCoreModel()->orWhere($where);
        return $this;
    }

    public function whereIn($column, array $values)
    {
        $this->getCoreModel()->whereIn($column, $values);
        return $this;
    }

    public function whereNotIn($column, array $values)
    {
        $this->getCoreModel()->whereNotIn($column, $values);
        return $this;
    }

    /**
     * 左括号
     */
    public function leftBracket()
    {
        $this->getCoreModel()->leftBracket();
        return $this;
    }

    /**
     * 右边括号
     */
    public function rightBracket()
    {
        $this->getCoreModel()->rightBracket();
        return $this;
    }

    //insert|update
    public function data(array $data)
    {
        $this->getCoreModel()->data($data);
        return $this;
    }

    public function setAction($action)
    {
        $this->getCoreModel()->setAction($action);
        return $this;
    }

    public function getSql()
    {
        return $this->getCmd()->setModel($this->getCoreModel())->getSql();
    }

    protected function log()
    {
        return $this->getCmd()->log();
    }

}
