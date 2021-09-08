<?php
namespace redb\mysql\make\component;

use redb\mysql\make\component\traits\returnTrait;
use redb\mysql\make\component\traits\commonTrait;
use redb\mysql\orm\ormModel;

class batchInsert
{
    protected $preSql;
    protected $partPresqlArr = [];
    protected $bindParams = [];

    use returnTrait, commonTrait;

    public function parseModelInfo(ormModel $model)
    {
        $table   = $model->getTable();
        $data    = $model->getData();

        return $this->parseBody($table)->parseData($data)->makePreSql();
    }

    protected function parseData($batchData=[])
    {
        if(empty($batchData)){
            return $this;
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
        $this->partPresqlArr[] = $preSql;

        return $this;
    }

    protected function parseBody($table)
    {
        $this->partPresqlArr[] = 'INSERT INTO `' . $table . '` ';

        return $this;
    }



}