<?php

namespace redb\make\component;

use redb\orm\ormModel;
use redb\make\component\traits\joinTrait;
use redb\make\component\traits\commonTrait;
use redb\make\component\traits\selectTrait;
use redb\make\component\interfaces\componentInterface;

class one implements componentInterface
{
    protected $preSql;
    protected $partPreSqlArr = [];
    protected $bindParams = [];

    use joinTrait, commonTrait, selectTrait;

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
                    ->parseLimit(1, 1)
                    ->parseHaving($model->getHaving())
                    ->parseOrderBy($model->getOrderBy())
                    ->parseLock($model->getLock())
                    ->parseUnion($model->getUnion())
                    ->makePreSql();
    }

    protected function parseBody($table, $select = '*', $alias = '')
    {
        empty($select) && $select = '*';
        $preSql       = 'SELECT ' . $select . ' FROM `' . $table . '` ';
        empty($alias) || $preSql .= 'ALIAS ' . $alias;
        $this->partPreSqlArr[] = $preSql;

        return $this;
    }

    protected function parseLock($lockStatus=false)
    {
        if(!$lockStatus){
            return $this;
        }
        $lockStatus && $preSql = 'FOR UPDATE';
        $this->partPreSqlArr[] = $preSql;

        return $this;
    }




}