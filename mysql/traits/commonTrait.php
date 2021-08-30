<?php
namespace redb\mysql\traits;

use redb\mysql\query\log;

trait commonTrait
{
    protected $client = [];

    public function close(){
        return $this->getCmd()->close();
    }

    public function reConnection(){
        return $this->getCmd()->close()->connection();
    }

    public function run()
    {
        return $this->getCmd()->run($this->getCoreModel());
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
        return $this->getCoreModel()->getSql();
    }

    /**
     * 获取历史以来执行的sql
     */
    public function getLog()
    {
        return log::getLog();
    }


}
