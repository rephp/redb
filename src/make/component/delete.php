<?php

namespace rephp\redb\make\component;

use rephp\redb\orm\ormModel;
use rephp\redb\make\component\traits\joinTrait;
use rephp\redb\make\component\traits\commonTrait;
use rephp\redb\make\component\interfaces\componentInterface;

/**
 * 生成删除sql
 * @package rephp\redb\make\component
 */
class delete implements componentInterface
{
    protected $preSql;
    protected $partPreSqlArr = [];
    protected $bindParams    = [];

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

        return $this->parseBody($table, $alias)->parseJoin($joinArr)->parseWhere($where)->makePreSql();
    }

    /**
     * 解析sql主体
     * @param string $table  数据表名字
     * @param string $alias  主表的重命名
     * @return $this
     */
    protected function parseBody($table, $alias = '')
    {
        $deleteObject = empty($alias) ? $table : $alias;
        $preSql       = 'DELETE ' . $deleteObject . ' FROM `' . $table . '`';
        empty($alias) || $preSql .= ' AS ' . $alias;
        $this->partPreSqlArr[] = $preSql;

        return $this;
    }


}