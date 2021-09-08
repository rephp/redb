<?php

namespace redb\mysql\make\component;

use redb\mysql\make\component\traits\returnTrait;
use redb\mysql\make\component\traits\joinTrait;
use redb\mysql\make\component\traits\commonTrait;
use redb\mysql\orm\ormModel;

class update
{
    protected $preSql;
    protected $partPresqlArr = [];
    protected $bindParams = [];

    use returnTrait, joinTrait, commonTrait;

    public function parseModelInfo(ormModel $model)
    {
        $where   = $model->getWhere();
        $joinArr = $model->getJoin();
        $table   = $model->getTable();
        $alias   = $model->getAlias();
        $data    = $model->getData();
        $incList = $model->getIncList();

        return $this->parseBody($table, $alias)
                    ->parseData($data, $incList)
                    ->parseJoin($joinArr)
                    ->parseWhere($where)
                    ->makePreSql();
    }

    protected function parseData($data = [], $incList=[])
    {
        if (empty($data)) {
            return $this;
        }
        $data      = (array)$data;
        $preSqlArr = [];
        foreach ($data as $key => $value) {
            $this->bindParams[] = $value;
            $preSql[]           = $key . '=?';
        }
        //自增
        $incList = (array)$incList;
        foreach ($incList as $item) {
            if ($item['type'] == 'inc') {
                $preSql[] = '`' . $item['column'] . '`=`' . $item['column'] . '` + ' . $item['step'];
            } else {//dec
                $preSql[] = '`' . $item['column'] . '`=`' . $item['column'] . '` - ' . $item['step'];
            }
        }

        $this->partPresqlArr = 'SET '.implode(',', $preSqlArr);

        return $this;
    }

    protected function parseBody($table, $alias = '')
    {
        $preSql = 'UPDATE `' . $table . '` ';
        empty($alias) || $preSql .= 'ALIAS ' . $alias;
        $this->partPresqlArr[] = $preSql;

        return $this;
    }

}