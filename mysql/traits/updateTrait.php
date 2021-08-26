<?php
namespace database\mysql\traits;

trait updateTrait
{

    public function update()
    {
        //1.生成sql并执行动作
        $this->getCoreModel()->setAction('update');

        return $this->run();
    }

}