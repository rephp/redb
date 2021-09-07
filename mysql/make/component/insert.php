<?php
namespace redb\mysql\make\component;

use redb\mysql\make\traits\returnTrait;
use redb\mysql\make\traits\commonTrait;
use redb\mysql\orm\ormModel;

class insert
{
    protected $preSql;
    protected $bodyPreSql;
    protected $bindParams = [];
    protected $dataPreSql;

    use returnTrait, commonTrait;

    public function parseModelInfo(ormModel $model)
    {
        $where   = $model->getWhere();
        $table   = $model->getTable();
        $data    = $model->getData();

        return $this->parseBody($table)->parseData($data)->makePreSql();
    }

    protected function parseData($data=[])
    {
        if(empty($data)){
            return false;
        }
        $data = (array)$data;
        $tempArr = [];
        $tempKeyArr = [];
        foreach($data as $index=>$value){
            $this->bindParams[] = $value;
            $tempArr[] = '?';
            $tempKeyArr[] = $index;
        }
        $this->dataPreSql = '('.implode(',', $tempKeyArr).') VALUES ('.implode(',', $tempArr).')';

        return $this;
    }

    protected function parseBody($table)
    {
        $this->bodyPreSql = 'INSERT INTO `' . $table . '` ';

        return $this;
    }

    protected function makePreSql()
    {
        $preSql = $this->bodyPreSql;
        $preSql .= ' SET '.$this->dataPreSql;
        $this->preSql = $preSql;

        return $this;
    }


}