<?php
namespace redb\mysql;


use redb\mysql\make\maker;
use redb\mysql\console\log;

class coreModel
{
    protected $page = 0;
    protected $limit = 0;
    protected $data = [];
    protected $where = [];
    protected $action;
    protected $alias;
    protected $join = [];
    protected $union = [];
    protected $orderBY;

    public function where($where)
    {
        $this->where[] = $where;
        return $this;
    }

    public function orWhere($where)
    {
        $this->where[] = ['OR'=>$where];
        return $this;
    }

    public function whereIn($column, array $values)
    {
        $this->where[] = [$column, 'IN', $values];
        return $this;
    }

    public function whereNotIn($column, array $values)
    {
        $this->where[] = [$column, 'NOT IN', $values];
        return $this;
    }

    /**
     * 左括号
     */
    public function leftBracket()
    {
        $this->where[] = ['('];
        return $this;
    }

    /**
     * 右边括号
     */
    public function rightBracket()
    {
        $this->where[] = [')'];
        return $this;
    }

    //insert|update
    public function data(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function page($page=0)
    {
        $page = (int)$page;
        ($page<1) && $page = 0;
        $this->page = $page;
        return $this;
    }

    public function limit($pageSize=0)
    {
        $pageSize = (int)$pageSize;
        ($pageSize<1) && $pageSize = 0;
        $this->limit = $pageSize;
        return $this;
    }

    public function alias($alias='')
    {
        $this->alias = $alias;
        return $this;
    }

    public function leftJoin($tableName, $on)
    {
        $this->join[] = [$tableName, $on, 'leftJoin'];
        return $this;
    }

    public function rightJoin($tableName, $on)
    {
        $this->join[] = [$tableName, $on, 'rightJoin'];
        return $this;
    }

    public function innerJoin($tableName, $on)
    {
        $this->join[] = [$tableName, $on, 'innerJoin'];
        return $this;
    }

    public function union(coreModel $model)
    {
        $this->union[] = $model;
        return $this;
    }

    public function orderBY($orderBy='')
    {
        $this->orderBY = $orderBy;
        return $this;
    }

    public function getSql()
    {
        return maker::getSql($this);
    }






}