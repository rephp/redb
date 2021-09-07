<?php

namespace redb\mysql\make\component;

use redb\mysql\orm\ormModel;
use redb\mysql\make\component\traits\returnTrait;
use redb\mysql\make\component\traits\joinTrait;
use redb\mysql\make\component\traits\commonTrait;

class one
{
    protected $preSql;
    protected $wherePreSql;
    protected $bodyPreSql;
    protected $joinPreSql;
    protected $bindParams = [];

    use returnTrait, joinTrait, commonTrait;

    public function parseModelInfo(ormModel $model)
    {
        $where   = $model->getWhere();
        $joinArr = $model->getJoin();
        $table   = $model->getTable();
        $alias   = $model->getAlias();
        $select  = $model->getSelect();

        return $this->parseBody($table, $select, $alias)
                    ->parseJoin($joinArr)
                    ->parseWhere($where)
                    ->parseGroupBy()
                    ->parseLimit()
                    ->parseHaving()
                    ->parseOrderBy()
                    ->parseLock()
                    ->parseUnion()
                    ->parseUnionAll()
                    ->makePreSql();
    }

    protected function parseBody($table, $select = '*', $alias = '')
    {
        $deleteObject = empty($alias) ? $table : $alias;
        $preSql       = 'SELECT ' . $select . ' FROM `' . $table . '` ';
        empty($alias) || $preSql .= 'ALIAS ' . $alias;
        $this->bodyPreSql = $preSql;

        return $this;
    }

    protected function parseLock()
    {

    }


    protected function makePreSql()
    {
        $preSql = $this->bodyPreSql;
        empty($this->joinPreSql) || $preSql .= ' ' . $this->joinPreSql;
        empty($this->wherePreSql) || $preSql .= ' WHERE ' . $this->wherePreSql;
        $this->preSql = $preSql;

        return $this;
    }

}