<?php

namespace rephp\redb\make\component;

use rephp\redb\orm\ormModel;
use rephp\redb\make\component\traits\joinTrait;
use rephp\redb\make\component\traits\commonTrait;
use rephp\redb\make\component\traits\selectTrait;
use rephp\redb\make\component\interfaces\componentInterface;

class all implements componentInterface
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
                    ->parseHaving($model->getHaving())
                    ->parseOrderBy($model->getOrderBy())
                    ->parseLimit($model->getPage(), $model->getLimit())
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

}