<?php
namespace redb\make\component;

use redb\make\component\traits\commonTrait;
use redb\orm\ormModel;
use redb\make\component\interfaces\componentInterface;

class batchInsert implements componentInterface
{
    protected $preSql;
    protected $partPreSqlArr = [];
    protected $bindParams = [];

    use commonTrait;

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
        $this->partPreSqlArr[] = $preSql;

        return $this;
    }

    protected function parseBody($table)
    {
        $this->partPreSqlArr[] = 'INSERT INTO `' . $table . '` ';

        return $this;
    }



}