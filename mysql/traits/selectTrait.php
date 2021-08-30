<?php
namespace redb\mysql\traits;

use redb\mysql\mysql;

trait selectTrait
{
    public function page($page=0)
    {
        $this->getCoreModel()->page($page);
        return $this;
    }

    public function limit($pageSize=0)
    {
        $this->getCoreModel()->limit($pageSize);
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

    public function alias($alias='')
    {
        $this->getCoreModel()->alias($alias);
        return $this;
    }

    public function leftJoin($tableName, $on)
    {
        $this->getCoreModel()->leftJoin($tableName, $on);
        return $this;
    }

    public function rightJoin($tableName, $on)
    {
        $this->getCoreModel()->rightJoin($tableName, $on);
        return $this;
    }

    public function innerJoin($tableName, $on)
    {
        $this->getCoreModel()->innerJoin($tableName, $on);
        return $this;
    }

    public function union(Mysql $client)
    {
        $this->getCoreModel()->union($client->getCoreModel());
        return $this;
    }

    public function lock()
    {
        $this->getCmd()->lock();
        return $this;
    }

    public function orderBy($orderBy='')
    {
        $this->getCoreModel()->orderBy($orderBy);
        return $this;
    }

    public function groupBy($groupBy='')
    {
        $this->getCoreModel()->groupBy($groupBy);
        return $this;
    }

    public function having($having='')
    {
        $this->getCoreModel()->having($having);
        return $this;
    }

}