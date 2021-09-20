<?php

namespace rephp\redb\make\component;

use rephp\redb\orm\ormModel;
use rephp\redb\make\component\traits\joinTrait;
use rephp\redb\make\component\traits\commonTrait;
use rephp\redb\make\component\traits\selectTrait;
use rephp\redb\make\component\interfaces\componentInterface;

/**
 * 获取单条sql
 * @package rephp\redb\make\component
 */
class one implements componentInterface
{
    protected $preSql;
    protected $partPreSqlArr = [];
    protected $bindParams = [];

    use joinTrait, commonTrait, selectTrait;

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
        $select  = $model->getSelect();

        return $this->parseBody($table, $select, $alias)
                    ->parseJoin($joinArr)
                    ->parseWhere($where)
                    ->parseGroupBy($model->getGroupBy())
                    ->parseHaving($model->getHaving())
                    ->parseOrderBy($model->getOrderBy())
                    ->parseLimit(1, 1)
                    ->parseLock($model->getLock())
                    ->parseUnion($model->getUnion())
                    ->makePreSql();
    }

    /**
     * 解析sql主体
     * @param string $table  数据表名字
     * @param string $select select字段列表
     * @param string $alias  主表的重命名
     * @return $this
     */
    protected function parseBody($table, $select = '*', $alias = '')
    {
        empty($select) && $select = '*';
        $preSql       = 'SELECT ' . $select . ' FROM `' . $table . '` ';
        empty($alias) || $preSql .= ' AS ' . $alias;
        $this->partPreSqlArr[] = $preSql;

        return $this;
    }

    /**
     * 解析行锁语句
     * @param bool $lockStatus  是否开启行锁
     * @return $this
     */
    protected function parseLock($lockStatus=false)
    {
        if(!$lockStatus){
            return $this;
        }
        $lockStatus && $preSql = 'FOR UPDATE';
        $this->partPreSqlArr[] = $preSql;

        return $this;
    }

}