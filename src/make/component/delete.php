<?php

namespace redb\make\component;

use redb\orm\ormModel;
use redb\make\component\traits\joinTrait;
use redb\make\component\traits\commonTrait;
use redb\make\component\interfaces\componentInterface;

class delete implements componentInterface
{
    protected $preSql;
    protected $partPreSqlArr = [];
    protected $bindParams    = [];

    use joinTrait, commonTrait;

    public function parseModelInfo(ormModel $model)
    {
        $where   = $model->getWhere();
        $joinArr = $model->getJoin();
        $table   = $model->getTable();
        $alias   = $model->getAlias();

        return $this->parseBody($table, $alias)->parseJoin($joinArr)->parseWhere($where)->makePreSql();
    }

    protected function parseBody($table, $alias = '')
    {
        $deleteObject = empty($alias) ? $table : $alias;
        $preSql       = 'DELETE ' . $deleteObject . ' FROM `' . $table . '` ';
        empty($alias) || $preSql .= 'ALIAS ' . $alias;
        $this->partPreSqlArr[] = $preSql;

        return $this;
    }


}