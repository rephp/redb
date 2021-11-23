<?php

namespace rephp\redb\traits;

use rephp\redb\redb;

/**
 * Trait selectTrait
 * @package rephp\redb\traits
 * @method  \rephp\redb\orm\ormModel getOrmModel()
 * @method \rephp\redb\query\cmd getCmd()
 * @method \rephp\redb\redb setAction()
 */
trait selectTrait
{
    /**
     * 设置页数
     * @param int $page 页数
     * @return $this
     */
    public function page($page = 0)
    {
        $this->getOrmModel()->page($page);
        return $this;
    }

    /**
     * 设置每页数据量
     * @param int $pageSize  每页多少条数据
     * @return $this
     */
    public function limit($pageSize = 0)
    {
        $this->getOrmModel()->limit($pageSize);
        return $this;
    }

    /**
     * 获取单条数据
     * @return array
     */
    public function one($isLock=false)
    {
        $this->getOrmModel()->lock($isLock);
        return $this->setAction('one')->run();
    }

    /**
     * 获取多条数据
     * @return array
     */
    public function all()
    {
        return $this->setAction('all')->run();
    }

    /**
     * 获取多条数据+条件筛选下的总记录数
     * @return array
     */
    public function fetch()
    {
        $list  = $this->all();
        $count = $this->count();
        return [
            'list'  => $list,
            'count' => $count,
        ];
    }

    /**
     * 查询条件下数据有多少条
     * @return int
     */
    public function count($select='COUNT(*) AS num')
    {
        return $this->setAction('count')->select($select)->limit(0)->page(0)->run();
    }

    /**
     * union联合查询
     * @param redb $client  redb对象
     * @return $this
     */
    public function union(redb $client)
    {
        $this->getOrmModel()->union($client->getOrmModel());
        return $this;
    }

    /**
     * union all联合查询
     * @param redb $client  redb对象
     * @return $this
     */
    public function unionAll(redb $client)
    {
        $this->getOrmModel()->unionAll($client->getOrmModel());
        return $this;
    }

    /**
     * 排序
     * @param string $orderBy 排序字符串如'cate_id ASC,id DESC'
     * @return $this
     */
    public function orderBy($orderBy = '')
    {
        $this->getOrmModel()->orderBy($orderBy);
        return $this;
    }

    /**
     * group语句
     * @param string $groupBy group语句（不含group by字样，如'cate_id'）
     * @return $this
     */
    public function groupBy($groupBy = '')
    {
        $this->getOrmModel()->groupBy($groupBy);
        return $this;
    }

    /**
     * having语句
     * @param string $groupBy having语句（不含having字样，如'num>2'）
     * @return $this
     */
    public function having($having = '')
    {
        $this->getOrmModel()->having($having);
        return $this;
    }

    /**
     * 设置查询语句中的select部分
     * @param  string  $selectRawString  select内容，如'id,title,create_time'或者'*'
     * @return $this
     */
    public function select($selectRawString)
    {
        $this->getOrmModel()->select($selectRawString);
        return $this;
    }


}