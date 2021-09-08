<?php
namespace redb\make;

use redb\orm\ormModel;

class maker
{
   protected $preSql;
   protected $bindParams=[];
   protected $com;

   public function __construct(ormModel $model)
   {
       $action    =  'redb\\make\\component\\'.$model->getAction();
       $this->com = (new $action())->parseModelInfo($model);
   }

   public function getComponent()
   {
       return $this->com;
   }

    public function getPreSql()
    {
        return $this->getComponent()->getPreSql();
    }

    public function getBindParams()
    {
        return $this->getComponent()->getBindParams();
    }

}