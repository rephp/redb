<?php

namespace rephp\redb\traits;
/**
 * Trait insertTrait
 * @package rephp\redb\traits
 * @method \rephp\redb\redb setAction()
 */
trait insertTrait
{

    /**
     * 普通插入
     * @param array $data 数据源，如果已经使用data方法配置数据，则无须传递任何参数
     * @return bool
     */
    public function insert($data = [])
    {
        empty($data) || $this->data($data);
        return $this->setAction('insert')->run();
    }

    /**
     * 替换式插入
     * @param array $data 数据源，如果已经使用data方法配置数据，则无须传递任何参数
     * @return bool
     */
    public function insertReplace($data = [])
    {
        empty($data) || $this->data($data);
        return $this->setAction('insertReplace')->run();
    }

    /**
     * 忽略式插入
     * @param array $data 数据源，如果已经使用data方法配置数据，则无须传递任何参数
     * @return bool
     */
    public function insertIgnore($data = [])
    {
        empty($data) || $this->data($data);
        return $this->setAction('insertIgnore')->run();
    }

    /**
     * 批量普通插入
     * @param array $data 数据源，如果已经使用data方法配置数据，则无须传递任何参数
     * @return bool
     */
    public function batchInsert($data = [])
    {
        empty($data) || $this->data($data);
        return $this->setAction('batchInsert')->run();
    }

    /**
     * 批量替换式插入
     * @param array $data 数据源，如果已经使用data方法配置数据，则无须传递任何参数
     * @return bool
     */
    public function batchInsertReplace($data = [])
    {
        empty($data) || $this->data($data);
        return $this->setAction('batchInsertReplace')->run();
    }

    /**
     * 批量忽略式插入
     * @param array $data 数据源，如果已经使用data方法配置数据，则无须传递任何参数
     * @return bool
     */
    public function batchInsertIgnore($data = [])
    {
        empty($data) || $this->data($data);
        return $this->setAction('batchInsertIgnore')->run();
    }


}