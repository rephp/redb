<?php

namespace redb\make\component;

use redb\make\component\traits\joinTrait;
use redb\make\component\traits\commonTrait;
use redb\orm\ormModel;
use redb\make\component\interfaces\componentInterface;

class update implements componentInterface
{
    protected $preSql;
    protected $partPreSqlArr = [];
    protected $bindParams = [];

    use joinTrait, commonTrait;

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

        $this->partPreSqlArr = 'SET '.implode(',', $preSqlArr);

        return $this;
    }

    protected function parseBody($table, $alias = '')
    {
        $preSql = 'UPDATE `' . $table . '` ';
        empty($alias) || $preSql .= 'ALIAS ' . $alias;
        $this->partPreSqlArr[] = $preSql;

        return $this;
    }

}