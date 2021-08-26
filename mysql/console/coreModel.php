<?php
namespace rephp\database\mysql\console;

final class coreModel
{
    public $page = 0;
    public $pageSize = 0;
    public $data = [];

    public function page($page=0)
    {
        $this->page = (int)$page;
        return $this;
    }

    public function limit($pageSize=0)
    {
        $this->limit = (int)$pageSize;
        return $this;
    }

    public function alias($alias='')
    {
        $this->limit = (string)$alias;
        return $this;
    }

    public function lock()
    {
        $this->limit = true;
        return $this;
    }

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function close(){
        return $this->getCmd()->close();
    }

    public function run()
    {
        $sql     = $this->getPreSql();
        $bindArr = $this->getBindArr();
        $this->log($sql, $bindArr);
        return $this->getCmd()->run($sql, $bindArr);
    }

    public function setAction($action='')
    {
        $this->action = $action;
        return $this;
    }

    public function getAction($action='')
    {
        return $this->action;
    }

    public function getPreSql()
    {
        if(empty($this->data)){
            //如果是插入，则需要判断是否批量操作
            if(count($this->data)==count($this->data, 1)) {
                //单条插入操作
            }else{
               //批量插入操作
            }
        }
    }

    public function getSql()
    {
        $sql     = $this->getPreSql();
        $bindArr = $this->getBindArr();

        $sql = str_replace('?', '%s', $sql);

        return vsprintf($sql, $bindArr);
    }


}