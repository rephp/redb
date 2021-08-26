<?php
namespace database\mysql\console;

class maker
{

    public function setCoreModel(coreModel $model)
    {
        $this->model = $model;
        return $this;
    }

    public function getCoreModel()
    {
        return $this->model;
    }

    public function getPreSql()
    {
        $action    =  $this->getCoreModel()->getAction();
        $actionArr = explode(' ', $action);
        $action    = current($actionArr);
        //todo:利用反射引入命名空间类，并调用方法
        return $instance->getPreSql($this->getCoreModel());
    }

    public function getBindArr()
    {
        $action    =  $this->getCoreModel()->getAction();
        $actionArr = explode(' ', $action);
        $action    = current($actionArr);
        //todo:利用反射引入命名空间类，并调用方法
        return $instance->getBindArr($this->getCoreModel());
    }

}