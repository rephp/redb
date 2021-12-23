<?php

namespace rephp\redb\make;

use rephp\redb\orm\ormModel;

/**
 * sql生成者
 * @package rephp\redb\make
 */
class maker
{
    protected $preSql;
    protected $bindParams = [];
    protected $com;

    /**
     * 初始化环境
     * @param ormModel $model
     */
    public function __construct(ormModel $model)
    {
        $action    = 'rephp\redb\\make\\component\\' . $model->getAction();
        $this->com = (new $action())->parseModelInfo($model);
    }

    /**
     * 获取生成sql的具体组件
     * @return mixed
     */
    public function getComponent()
    {
        return $this->com;
    }

    /**
     * 获取presql
     * @return mixed
     */
    public function getPreSql()
    {
        return $this->getComponent()->getPreSql();
    }

    /**
     * 获取绑定参数
     * @return mixed
     */
    public function getBindParams()
    {
        return $this->getComponent()->getBindParams();
    }
}
