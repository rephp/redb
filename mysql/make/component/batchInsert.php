<?php
namespace redb\mysql\make\component;

use redb\mysql\make\traits\returnTrait;
use redb\mysql\make\traits\commonTrait;
use redb\mysql\orm\ormModel;

class batchInsert
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

    protected function parseData($batchData=[])
    {
        if(empty($batchData)){
            return false;
        }
        $batchData = (array)$batchData;
        $data = current($batchData);
        $data = (array)$data;
        $tempArr = [];
        $tempKeyArr = [];
        foreach($data as $index=>$value){
            $tempArr[] = '?';
            $tempKeyArr[] = $index;
        }
        $preSql = '('.implode(',', $tempKeyArr).') VALUES ';
        $splitStr = '';
        foreach($batchData as $item){
            array_push($this->bindParams, ...array_values($item));
            $preSql .= $splitStr.'('.implode(',', $tempArr).')';
            $splitStr = ',';
        }
        $this->dataPreSql = $preSql;

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