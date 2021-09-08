<?php
namespace redb\mysql\make\component;

use redb\mysql\make\component\traits\returnTrait;
use redb\mysql\make\component\traits\commonTrait;
use redb\mysql\orm\ormModel;

class insert
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
        $this->partPresqlArr[] = '('.implode(',', $tempKeyArr).') VALUES ('.implode(',', $tempArr).')';

        return $this;
    }

    protected function parseBody($table)
    {
        $this->partPresqlArr[] = 'INSERT INTO `' . $table . '` ';

        return $this;
    }

}