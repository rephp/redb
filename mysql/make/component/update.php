<?php

namespace redb\mysql\make\component;

use redb\mysql\make\component\traits\returnTrait;
use redb\mysql\make\component\traits\joinTrait;
use redb\mysql\make\component\traits\commonTrait;
use redb\mysql\orm\ormModel;

class update
{
    protected $preSql;
    protected $wherePreSql;
    protected $bodyPreSql;
    protected $joinPreSql;
    protected $bindParams = [];
    protected $dataPreSql;
    protected $incPreSql;

    use returnTrait, joinTrait, commonTrait;

    public function parseModelInfo(ormModel $model)
    {
        $where   = $model->getWhere();
        $joinArr = $model->getJoin();
        $table   = $model->getTable();
        $alias   = $model->getAlias();
        $data    = $model->getData();
        $incList = $model->getIncList();

        return $this->parseBody($table, $alias)->parseData($data)->parseIncList($incList)->parseJoin($joinArr)->parseWhere($where)->makePreSql();
    }

    protected function parseData($data = [])
    {
        if (empty($data)) {
            return false;
        }
        $data      = (array)$data;
        $preSqlArr = [];
        foreach ($data as $key => $value) {
            $this->bindParams[] = $value;
            $preSql[]           = $key . '=?';
        }
        $this->dataPreSql = implode(',', $preSqlArr);

        return true;
    }

    protected function parseIncList($incList)
    {
        if (empty($incList)) {
            return true;
        }
        $incList   = (array)$incList;
        $preSqlArr = [];
        foreach ($incList as $item) {
            if ($item['type'] == 'inc') {
                $preSqlArr[] = '`' . $item['column'] . '`=`' . $item['column'] . '` + ' . $item['step'];
            } else {//dec
                $preSqlArr[] = '`' . $item['column'] . '`=`' . $item['column'] . '` - ' . $item['step'];
            }
        }
        $this->incPreSql = implode(',', $preSqlArr);

        return $this;
    }

    protected function parseBody($table, $alias = '')
    {
        $preSql = 'UPDATE `' . $table . '` ';
        empty($alias) || $preSql .= 'ALIAS ' . $alias;
        $this->bodyPreSql = $preSql;

        return $this;
    }

    protected function makePreSql()
    {
        $preSql = $this->bodyPreSql;
        empty($this->joinPreSql) || $preSql .= ' ' . $this->joinPreSql;
        if (empty($this->dataPreSql) || empty($this->incPreSql)) {
            empty($this->dataPreSql) || $preSql .= ' SET ' . $this->dataPreSql;
            empty($this->incPreSql)  || $preSql .= ' SET ' . $this->incPreSql;
        } else {
            $preSql .= ' SET ' . $this->dataPreSql . ',' . $this->incPreSql;
        }

        empty($this->wherePreSql) || $preSql .= ' WHERE ' . $this->wherePreSql;
        $this->preSql = $preSql;

        return $this;
    }

}