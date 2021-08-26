<?php
namespace database\mysql\traits;

trait deleteTrait
{

    /**
     * 删除
     * @return mixed
     */
    public function delete()
    {
        //1.生成sql并执行动作
        $this->getCoreModel()->setAction('delete');

        return $this->run();
    }
}