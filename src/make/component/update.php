<?php

namespace rephp\redb\make\component;

use rephp\redb\make\component\traits\joinTrait;
use rephp\redb\make\component\traits\commonTrait;
use rephp\redb\orm\ormModel;
use rephp\redb\make\component\interfaces\componentInterface;

/**
 * 生成修改sql
 * @package rephp\redb\make\component
 */
class update implements componentInterface
{
    protected $preSql;
    protected $partPreSqlArr = [];
    protected $bindParams = [];

    use joinTrait, commonTrait;

    /**
     * 解析model对象，生成sql
     * @param ormModel $model orm模型对象
     * @return string
     */
    public function parseModelInfo(ormModel $model)
    {
        $where   = $model->getWhere();
        $joinArr = $model->getJoin();
        $table   = $model->getTable();
        $alias   = $model->getAlias();
        $data    = $model->getData();
        $incList = $model->getIncList();

        return $this->parseBody($table, $alias)
                    ->parseJoin($joinArr)
                    ->parseData($data, $incList)
                    ->parseWhere($where)
                    ->makePreSql();
    }

    /**
     * 解析对象数据
     * @param array $batchData  对象数据
     * @return $this
     */
    protected function parseData($data = [], $incList=[])
    {
        if (empty($data)) {
            return $this;
        }
        $data      = (array)$data;
        $preSqlArr = [];
        foreach ($data as $key => $value) {
            $this->bindParams[] = $value;
            $preSqlArr[]           = $key . '=?';
        }
        //自增
        foreach ($incList as $item) {
            if ($item['type'] == 'inc') {
                $this->bindParams[] = $item['step'];
                $preSqlArr[] = '`' . $item['column'] . '`=`' . $item['column'] . '` + ?';
            } else {//dec
                $this->bindParams[] = $item['step'];
                $preSqlArr[] = '`' . $item['column'] . '`=`' . $item['column'] . '` - ?';
            }
        }

        $this->partPreSqlArr[] = 'SET '.implode(',', $preSqlArr);

        return $this;
    }

    /**
     * 解析sql主体
     * @param string $table  数据表名字
     * @param string $alias  主表的重命名
     * @return $this
     */
    protected function parseBody($table, $alias = '')
    {
        $preSql = 'UPDATE `' . $table . '`';
        empty($alias) || $preSql .= ' AS ' . $alias;
        $this->partPreSqlArr[] = $preSql;

        return $this;
    }

}