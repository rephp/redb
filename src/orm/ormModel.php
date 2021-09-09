<?php

namespace rephp\redb\orm;


use rephp\redb\make\maker;

class ormModel
{
    protected $maker;
    protected $page    = 0;
    protected $limit   = 0;
    protected $data    = [];
    protected $where   = [];
    protected $incList = [];
    protected $action;
    protected $alias;
    protected $join    = [];
    protected $union   = [];
    protected $orderBy;
    protected $groupBy;
    protected $having;
    protected $select;
    protected $lock    = false;

    protected function maker()
    {
        if (!is_object($this->maker)) {
            $this->maker = new maker($this);
        }
        return $this->maker;
    }

    public function getWhere()
    {
        return $this->where;
    }

    public function where($where)
    {
        $this->where[] = $where;
        return $this;
    }

    public function orQuery()
    {
        $this->where[] = ['OR'];
        return $this;
    }

    public function orWhere($where)
    {
        $this->orQuery()->where($where);
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

    public function like($column, $value)
    {
        $this->where[] = [$column, 'LIKE', $value];
        return $this;
    }

    public function notLike($column, $value)
    {
        $this->where[] = [$column, 'NOT LIKE', $value];
        return $this;
    }

    public function between($column, $min, $max)
    {
        $this->where[] = [$column, 'BETWEEN', [$min, $max]];
        return $this;
    }

    public function notBetween($column, $min, $max)
    {
        $this->where[] = [$column, 'NOT BETWEEN', [$min, $max]];
        return $this;
    }

    public function lock()
    {
        $this->lock = true;
        return $this;
    }

    public function getLock()
    {
        return $this->lock;
    }

    /**
     * 左括号
     */
    public function whereLeftBracket()
    {
        $this->where[] = ['('];
        return $this;
    }

    /**
     * 右边括号
     */
    public function WhereRightBracket()
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

    public function getData()
    {
        return $this->data;
    }

    public function inc($column, $step = 1)
    {
        $this->incList[] = ['type' => 'inc', 'column' => $column, 'step' => $step];
        return $this;
    }

    public function dec($column, $step = 1)
    {
        $this->incList[] = ['type' => 'dec', 'column' => $column, 'step' => $step];
        return $this;
    }

    public function getIncList()
    {
        return $this->incList;
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function page($page = 0)
    {
        $page = (int)$page;
        ($page < 1) && $page = 0;
        $this->page = $page;
        return $this;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function limit($pageSize = 0)
    {
        $pageSize = (int)$pageSize;
        ($pageSize < 1) && $pageSize = 0;
        $this->limit = $pageSize;
        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function alias($alias = '')
    {
        $this->alias = $alias;
        return $this;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function leftJoin($tableName, $on)
    {
        $this->join[] = ['LEFT JOIN', $tableName, $on];
        return $this;
    }

    public function rightJoin($tableName, $on)
    {
        $this->join[] = ['RIGHT JOIN', $tableName, $on];
        return $this;
    }

    public function innerJoin($tableName, $on)
    {
        $this->join[] = ['INNER JOIN', $tableName, $on];
        return $this;
    }

    public function getJoin()
    {
        return $this->join;
    }

    public function union(ormModel $model)
    {
        $model->limit(0)->page(0)->setAction('all');
        $this->union[] = ['type' => 'UNION', 'model' => $model];
        return $this;
    }

    public function unionAll(ormModel $model)
    {
        $model->limit(0)->page(0)->setAction('all');
        $this->union[] = ['type' => 'UNION ALL', 'model' => $model];
        return $this;
    }

    public function getUnion()
    {
        return $this->union;
    }

    public function orderBy($orderBy = '')
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function getOrderBy()
    {
        return $this->orderBy;
    }

    public function groupBy($groupBy = '')
    {
        $this->groupBy = $groupBy;
        return $this;
    }

    public function getGroupBy()
    {
        return $this->groupBy;
    }

    public function having($having = '')
    {
        $this->having = $having;
        return $this;
    }

    public function getHaving()
    {
        return $this->having;
    }

    public function select($select)
    {
        $this->select = $select;
        return $this;
    }

    public function getSelect()
    {
        return $this->select;
    }

    public function getSql()
    {
        $preSql     = $this->maker()->getPresql();
        $bindParams = $this->maker()->getBindParams();
        return vsprintf(str_replace('?', '%s', $preSql), $bindParams);
    }

    public function getPresql()
    {
        return $this->maker()->getPresql();
    }

    public function getBindParams()
    {
        return $this->maker()->getBindParams();
    }


}