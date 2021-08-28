<?php
namespace redb\mysql\make\component;

use redb\mysql\console\coreModel;

class insert
{

    public function getPreSql(coreModel $model)
    {
        $data    = $model->getData();
        $action  = $model->getAction();
        $count   = count($data);
        $reCount = count($data, 1);
        if($count==$reCount){
            //单条插入
        }else{
            //批量插入
        }

    }

    public function getBindArr(coreModel $model)
    {
        $data    = $model->getData();
        $action  = $model->getAction();
        $count   = count($data);
        $reCount = count($data, 1);
        if($count==$reCount){
            //单条插入
        }else{
            //批量插入
        }
    }
}