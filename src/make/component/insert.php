<?php
namespace redb\make\component;

use redb\make\component\traits\commonTrait;
use redb\orm\ormModel;
use redb\make\component\interfaces\componentInterface;

class insert implements componentInterface
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
        $this->partPreSqlArr[] = '('.implode(',', $tempKeyArr).') VALUES ('.implode(',', $tempArr).')';

        return $this;
    }

    protected function parseBody($table)
    {
        $this->partPreSqlArr[] = 'INSERT INTO `' . $table . '` ';

        return $this;
    }

}