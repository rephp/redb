<?php
namespace redb\mysql\make;

class maker
{

    public static function getPreSql(coreModel $model)
    {
        $action    =  $model->getAction();
        $actionArr = explode(' ', $action);
        $action    = current($actionArr);
        //todo:利用反射引入命名空间类，并调用方法
        return $instance->getPreSql($model);
    }

    public static function getBindArr(coreModel $model)
    {
        $action    =  $model->getAction();
        $actionArr = explode(' ', $action);
        $action    = current($actionArr);
        //todo:利用反射引入命名空间类，并调用方法
        return $instance->getBindArr($model);
    }

}