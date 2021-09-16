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
    public function page($page = 0)
    {
        $this->getOrmModel()->page($page);
        return $this;
    }

    public function limit($pageSize = 0)
    {
        $this->getOrmModel()->limit($pageSize);
        return $this;
    }

    public function one()
    {
        return $this->setAction('one')->run();
    }

    public function all()
    {
        return $this->setAction('all')->run();
    }

    public function fetch()
    {
        $counter = clone $this;
        $list  = $this->all();
        $count = $counter->count();
        return [
            'list'  => $list,
            'count' => $count,
        ];
    }


    public function count()
    {
        return $this->setAction('count')->limit(0)->page(0)->run();
    }

    public function union(redb $client)
    {
        $this->getOrmModel()->union($client->getOrmModel());
        return $this;
    }

    public function unionAll(redb $client)
    {
        $this->getOrmModel()->unionAll($client->getOrmModel());
        return $this;
    }

    public function lock()
    {
        $this->getOrmModel()->lock();
        return $this;
    }

    public function orderBy($orderBy = '')
    {
        $this->getOrmModel()->orderBy($orderBy);
        return $this;
    }

    public function groupBy($groupBy = '')
    {
        $this->getOrmModel()->groupBy($groupBy);
        return $this;
    }

    public function having($having = '')
    {
        $this->getOrmModel()->having($having);
        return $this;
    }

    public function select($selectRawString)
    {
        $this->getOrmModel()->select($selectRawString);
        return $this;
    }


}