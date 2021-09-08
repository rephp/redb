<?php

namespace redb\mysql\make\component;

use redb\mysql\orm\ormModel;
use redb\mysql\make\component\traits\returnTrait;
use redb\mysql\make\component\traits\joinTrait;
use redb\mysql\make\component\traits\commonTrait;
use redb\mysql\make\component\traits\selectTrait;

class all
{
    protected $preSql;
    protected $partPresqlArr = [];
    protected $bindParams = [];

    use returnTrait, joinTrait, commonTrait, selectTrait;

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
                    ->parseGroupBy($model->getGroupBy())
                    ->parseLimit($model->getPage(), $model->getLimit())
                    ->parseHaving($model->getHaving())
                    ->parseOrderBy($model->getOrderBy())
                    ->parseUnion($model->getUnion())
                    ->makePreSql();
    }

    protected function parseBody($table, $select = '*', $alias = '')
    {
        $deleteObject = empty($alias) ? $table : $alias;
        $preSql       = 'SELECT ' . $select . ' FROM `' . $table . '` ';
        empty($alias) || $preSql .= 'ALIAS ' . $alias;
        $this->partPresqlArr[] = $preSql;

        return $this;
    }

}