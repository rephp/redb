<?php
namespace rephp\database\mysql\traits;

trait updateTrait
{

    public function update()
    {
        //生成sql并执行动作
        $this->getCoreModel()->action = 'update';

        return $this->run();
    }

}