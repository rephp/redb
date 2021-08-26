<?php
namespace database\mysql\traits;

trait insertTrait
{

    public function insert()
    {
        //1.生成sql并执行动作
        $this->getCoreModel()->setAction('insert');

        return $this->run();
    }

    public function insertReplace()
    {
        //1.生成sql并执行动作
        $this->getCoreModel()->setAction('insert replace');

        return $this->run();
    }

    public function insertIgnore()
    {
        //1.生成sql并执行动作
        $this->getCoreModel()->setAction('insert ignore');

        return $this->run();
    }

}