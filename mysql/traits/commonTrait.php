<?php

namespace redb\mysql\traits;

use redb\mysql\query\log;

/**
 * Trait commonTrait
 * @package redb\mysql\traits
 * @method  \redb\mysql\ormModel getOrmModel()
 * @method \redb\mysql\query\cmd getCmd()
 */

trait commonTrait
{
    protected $client = [];

    public function close()
    {
        return $this->getCmd()->close();
    }

    public function reConnection()
    {
        return $this->getCmd()->close()->connection();
    }

    public function run()
    {
        return $this->getCmd()->run($this->getOrmModel());
    }


    //update|select|delete
    public function where($where)
    {
        $this->getOrmModel()->where($where);
        return $this;
    }

    public function orWhere($where)
    {
        $this->getOrmModel()->orWhere($where);
        return $this;
    }

    public function whereIn($column, array $values)
    {
        $this->getOrmModel()->whereIn($column, $values);
        return $this;
    }

    public function whereNotIn($column, array $values)
    {
        $this->getOrmModel()->whereNotIn($column, $values);
        return $this;
    }

    /**
     * 左括号
     */
    public function leftBracket()
    {
        $this->getOrmModel()->leftBracket();
        return $this;
    }

    /**
     * 右边括号
     */
    public function rightBracket()
    {
        $this->getOrmModel()->rightBracket();
        return $this;
    }

    //insert|update
    public function data(array $data)
    {
        $this->getOrmModel()->data($data);
        return $this;
    }

    public function setAction($action)
    {
        $this->getOrmModel()->setAction($action);
        return $this;
    }

    public function getSql()
    {
        return $this->getOrmModel()->getSql();
    }

    /**
     * 获取历史以来执行的sql
     */
    public function getLog()
    {
        return log::getLog();
    }


}
