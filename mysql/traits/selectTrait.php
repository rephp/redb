<?php
namespace rephp\database\mysql\traits;

use rephp\database\mysql\mysql;

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
        $this->getCoreModel()->page(1)->limit(1)->setAction('select');
        return $this->run();
    }

    public function all()
    {
        $this->getCoreModel()->setAction('select');
        return $this->run();
    }

    /**
     * 自动分页
     * @param int $limit
     */
    public function autoPage($limit=1)
    {
        $limit = (int)$limit;
        ($limit<1) && $limit = 1;
        $this->getCoreModel()->limit(1);

        return $this;
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

    public function union(Mysql $model)
    {
        $this->getCoreModel()->union($model->getCoreModel());
        return $this;
    }

    public function lock()
    {
        $this->getCoreModel()->lock();
        return $this;
    }

    public function orderBY($orderBy='')
    {
        $this->getCoreModel()->orderBY($orderBy);
        return $this;
    }




}