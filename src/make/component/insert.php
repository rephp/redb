<?php
namespace rephp\redb\make\component;

use rephp\redb\make\component\traits\commonTrait;
use rephp\redb\orm\ormModel;
use rephp\redb\make\component\interfaces\componentInterface;

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
        $this->partPreSqlArr[] = 'INSERT INTO `' . $table . '`';

        return $this;
    }

}