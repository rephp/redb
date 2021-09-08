<?php
namespace redb\mysql\make\component\traits;

use redb\mysql\orm\ormModel;

trait selectTrait
{
    protected function parseGroupBy($groupBy='')
    {
        if(empty($groupBy)){
            return $this;
        }
        $this->partPresqlArr[] = $groupBy;

        return $this;
    }

    protected function parseLimit($page=0, $pageSize=0)
    {
        if(empty($page) && empty($pageSize)){
            return $this;
        }
        $page<1 &&  $page=1;
        $pageSize<1 &&  $pageSize=1;
        $this->partPresqlArr[] = 'LIMIT '.($page-1)*$pageSize.','.$pageSize;

        return $this;
    }

    protected function parseHaving($having='')
    {
        if(empty($having)){
            return $this;
        }
        $this->partPresqlArr[] = $having;

        return $this;
    }

    protected function parseOrderBy($orderBy='')
    {
        if(empty($orderBy)){
            return $this;
        }
        $this->partPresqlArr[] = $orderBy;

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
            empty($sql) || $this->partPresqlArr[] = $action.' ('.$sql.')';
        }

        return $this;
    }


}