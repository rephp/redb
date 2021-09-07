<?php
namespace redb\mysql\traits;

use redb\mysql\mysql;

/**
 * Trait selectTrait
 * @package redb\mysql\traits
 * @method  \redb\mysql\orm\ormModel getOrmModel()
 * @method \redb\mysql\query\cmd getCmd()
 * @method \redb\mysql\mysql setAction()
 */
trait selectTrait
{
    public function page($page=0)
    {
        $this->getOrmModel()->page($page);
        return $this;
    }

    public function limit($pageSize=0)
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

    public function count()
    {
        return $this->setAction('count')->run();
    }

    /**
     * 自动分页
     * @param int $limit
     */
    public function autoPage($pageSize=1)
    {
        $pageSize = (int)$pageSize;
        ($pageSize<1) && $pageSize = 1;
        return $this->limit($pageSize);
    }


    public function union(Mysql $client)
    {
        $this->getOrmModel()->union($client->getOrmModel());
        return $this;
    }

    public function unionAll(Mysql $client)
    {
        $this->getOrmModel()->unionAll($client->getOrmModel());
        return $this;
    }

    public function lock()
    {
        $this->getCmd()->lock();
        return $this;
    }

    public function orderBy($orderBy='')
    {
        $this->getOrmModel()->orderBy($orderBy);
        return $this;
    }

    public function groupBy($groupBy='')
    {
        $this->getOrmModel()->groupBy($groupBy);
        return $this;
    }

    public function having($having='')
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