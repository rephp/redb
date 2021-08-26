<?php
namespace rephp\database\mysql\traits;

use rephp\database\mysql\mysql;

trait selectTrait
{
    public function page($page=0)
    {
        $page = (int)$page;
        ($page<1) && $page = 0;
        $this->getCoreModel()->page = $page;
        return $this;
    }

    public function limit($pageSize=0)
    {
        $pageSize = (int)$pageSize;
        ($pageSize<1) && $pageSize = 0;
        $this->getCoreModel()->limit = $pageSize;
        return $this;
    }

    public function one()
    {
        $this->getCoreModel()->action = 'select';
        return $this->page(1)->limit(1)->run();
    }

    public function all()
    {
        $this->getCoreModel()->action = 'select';
        return $this->run();
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
        $this->getCoreModel()->alias = $alias;
        return $this;
    }

    public function leftJoin($tableName, $on)
    {
        $this->getCoreModel()->leftJoin[] = [$tableName, $on];
        return $this;
    }

    public function rightJoin($tableName, $on)
    {
        $this->getCoreModel()->rightJoin[] = [$tableName, $on];
        return $this;
    }

    public function innerJoin($tableName, $on)
    {
        $this->getCoreModel()->innerJoin[] = [$tableName, $on];
        return $this;
    }

    public function union(Mysql $model)
    {
        $this->getCoreModel()->union[] = $model->getCoreModel();
        return $this;
    }

    public function lock()
    {
        $this->getCmd()->lock();
        return $this;
    }

    public function orderBY($orderBy='')
    {

        $this->getCoreModel()->orderBY = $orderBy;
        return $this;
    }




}