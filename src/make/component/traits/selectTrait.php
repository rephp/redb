<?php
namespace redb\make\component\traits;

use redb\orm\ormModel;

trait selectTrait
{
    protected function parseGroupBy($groupBy='')
    {
        if(empty($groupBy)){
            return $this;
        }
        $this->partPreSqlArr[] = 'GROUP BY '.$groupBy;

        return $this;
    }

    protected function parseLimit($page=0, $pageSize=0)
    {
        if(empty($page) && empty($pageSize)){
            return $this;
        }
        $page<1 &&  $page=1;
        $pageSize<1 &&  $pageSize=1;
        $this->partPreSqlArr[] = 'LIMIT '.($page-1)*$pageSize.','.$pageSize;

        return $this;
    }

    protected function parseHaving($having='')
    {
        if(empty($having)){
            return $this;
        }
        $this->partPreSqlArr[] = 'HAVING '.$having;

        return $this;
    }

    protected function parseOrderBy($orderBy='')
    {
        if(empty($orderBy)){
            return $this;
        }
        $this->partPreSqlArr[] = 'ORDER BY '.$orderBy;

        return $this;
    }


    protected function parseUnion($modelList)
    {
        if(empty($modelList)){
            return $this;
        }
        /**
         * @var ormModel $model
         */
        foreach($modelList as $item){
            $model  = $item['model'];
            $action = $item['type'];
            $sql = $model->getSql();
            empty($sql) || $this->partPreSqlArr[] = $action.' ('.$sql.')';
        }

        return $this;
    }


}