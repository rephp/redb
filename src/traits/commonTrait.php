<?php

namespace redb\traits;

use redb\query\log;

/**
 * Trait commonTrait
 * @package redb\traits
 * @method  \redb\orm\ormModel getOrmModel()
 * @method \redb\query\cmd getCmd()
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
    public function where($where, $opt='=', $value='')
    {
        if(is_array($where)){
            foreach ($where as $key => $value) {
                $this->getOrmModel()->where([$key, '=', $value]);
            }
            return $this;
        }
        $this->getOrmModel()->where([$where, $opt, $value]);
        return $this;
    }

    public function orWhere($column, $opt='=', $value='')
    {
        $this->getOrmModel()->orWhere([$column, $opt, $value]);
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

    public function like($column, $value)
    {
        $this->getOrmModel()->like($column, $value);
        return $this;
    }

    public function notLike($column, $value)
    {
        $this->getOrmModel()->notLike($column, $value);
        return $this;
    }

    public function between($column, $min, $max)
    {
        $this->getOrmModel()->between($column, $min, $max);
        return $this;
    }

    public function notBetween($column, $min, $max)
    {
        $this->getOrmModel()->notBetween($column, $min, $max);
        return $this;
    }


    public function alias($alias='')
    {
        $this->getOrmModel()->alias($alias);
        return $this;
    }

    public function leftJoin($tableName, $on)
    {
        $this->getOrmModel()->leftJoin($tableName, $on);
        return $this;
    }

    public function rightJoin($tableName, $on)
    {
        $this->getOrmModel()->rightJoin($tableName, $on);
        return $this;
    }

    public function innerJoin($tableName, $on)
    {
        $this->getOrmModel()->innerJoin($tableName, $on);
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
