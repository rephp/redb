<?php

namespace rephp\redb\make\component;

use rephp\redb\orm\ormModel;
use rephp\redb\make\component\traits\joinTrait;
use rephp\redb\make\component\traits\commonTrait;
use rephp\redb\make\component\interfaces\componentInterface;

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
        $preSql       = 'DELETE ' . $deleteObject . ' FROM `' . $table . '`';
        empty($alias) || $preSql .= 'ALIAS ' . $alias;
        $this->partPreSqlArr[] = $preSql;

        return $this;
    }


}