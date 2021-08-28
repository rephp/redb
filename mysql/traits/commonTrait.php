<?php
namespace rephp\database\mysql\traits;

use rephp\database\mysql\console\coreModel;

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
        $this->getCoreModel()->where[] = $where;
        return $this;
    }

    public function orWhere($where)
    {
        $this->getCoreModel()->where[] = ['OR'=>$where];
        return $this;
    }

    public function whereIn($column, array $values)
    {
        $this->getCoreModel()->where[] = [$column, 'IN', $values];
        return $this;
    }

    public function whereNotIn($column, array $values)
    {
        $this->getCoreModel()->where[] = [$column, 'NOT IN', $values];
        return $this;
    }

    /**
     * 左括号
     */
    public function leftBracket()
    {
        $this->getCoreModel()->where[] = ['('];
        return $this;
    }

    /**
     * 右边括号
     */
    public function rightBracket()
    {
        $this->getCoreModel()->where[] = [')'];
        return $this;
    }

    //insert|update
    public function data(array $data)
    {
        $this->getCoreModel()->data = $data;
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
