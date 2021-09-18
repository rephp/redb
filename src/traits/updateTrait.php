<?php

namespace rephp\redb\traits;
/**
 * Trait updateTrait
 * @package rephp\redb\traits
 * @method \rephp\redb\redb setAction()
 */
trait updateTrait
{
    /**
     * 自增
     * @param string $column 字段名
     * @param int    $step   自增步长（正正数或者正浮点数）
     * @return $this
     */
    public function inc($column, $step = 1)
    {
        $this->getOrmModel()->inc($column, $step);
        return $this;
    }

    /**
     * 自减
     * @param string $column 字段名
     * @param int    $step   自增步长（正正数或者正浮点数）
     * @return $this
     */
    public function dec($column, $step = 1)
    {
        $this->getOrmModel()->dec($column, $step);
        return $this;
    }

    /**
     * 修改数据
     * @param array $data 数据源，如果已经使用data方法配置数据，则无须传递任何参数
     * @return bool
     */
    public function update($data = [])
    {
        empty($data) || $this->data($data);
        return $this->setAction('update')->run();
    }

}