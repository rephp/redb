<?php
namespace rephp\redb\make\component;

use rephp\redb\make\component\traits\commonTrait;
use rephp\redb\orm\ormModel;
use rephp\redb\make\component\interfaces\componentInterface;

/**
 * 生成单条普通插入sql
 * @package rephp\redb\make\component
 */
class insert implements componentInterface
{
    protected $preSql;
    protected $partPreSqlArr = [];
    protected $bindParams = [];

    use commonTrait;

    /**
     * 解析model对象，生成sql
     * @param ormModel $model orm模型对象
     * @return string
     */
    public function parseModelInfo(ormModel $model)
    {
        $table   = $model->getTable();
        $data    = $model->getData();

        return $this->parseBody($table)->parseData($data)->makePreSql();
    }

    /**
     * 解析对象数据
     * @param array $batchData  对象数据
     * @return $this
     */
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

    /**
     * 解析sql主体
     * @param string $table  数据表名字
     * @return $this
     */
    protected function parseBody($table)
    {
        $this->partPreSqlArr[] = 'INSERT INTO `' . $table . '`';

        return $this;
    }

}