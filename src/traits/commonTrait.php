<?php

namespace rephp\redb\traits;

use rephp\redb\query\log;

/**
 * Trait commonTrait
 * @package rephp\redb\traits
 * @method  \rephp\redb\orm\ormModel getOrmModel()
 * @method \rephp\redb\query\cmd getCmd()
 */
trait commonTrait
{
    protected $client = [];

    public function close()
    {
        return $this->getCmd()->close();
    }

    public function reConnect()
    {
        return $this->getCmd()->close()->connect();
    }

    public function run()
    {
        return $this->getCmd()->run($this->getOrmModel());
    }

    public function where($where, $value='', $opt = '=')
    {
        if (is_array($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    $tempWhere = $value;
                } else {
                    $tempWhere = is_numeric($key) ? [$value] : [$key, '=', $value];
                }
                $this->getOrmModel()->where($tempWhere);
            }
            return $this;
        }
        $this->getOrmModel()->where([$where, $opt, $value]);
        return $this;
    }

    public function orWhere($column, $value, $opt = '=')
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


    public function alias($alias = '')
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
    public function whereLeftBracket()
    {
        $this->getOrmModel()->whereLeftBracket();
        return $this;
    }

    /**
     * 右边括号
     */
    public function WhereRightBracket()
    {
        $this->getOrmModel()->WhereRightBracket();
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
