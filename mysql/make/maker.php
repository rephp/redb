<?php
namespace redb\mysql\make;

use redb\mysql\orm\ormModel;

class maker
{
   protected $preSql;
   protected $bindParams=[];
   protected $com;

   public function getComponent(ormModel $model)
   {
       if(!is_object($this->com)){
           $action    =  $model->getAction();
           $actionArr = explode(' ', $action);
           $action    = current($actionArr);
           $this->com = (new $action())->parseModelInfo($model);
       }
       return $this->com;
   }

    public function getPreSql(coreModel $model)
    {
        return $this->getComponent($model)->getPreSql();
    }

    public function getBindParams(coreModel $model)
    {
        return $this->getComponent($model)->getBindParams();
    }

}