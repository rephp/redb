<?php
namespace rephp\database\mysql\traits;

trait deleteTrait
{

    /**
     * 删除
     * @return mixed
     */
    public function delete()
    {
        //生成sql并执行动作
        $this->getCoreModel()->action = 'delete';

        return $this->run();
    }
}