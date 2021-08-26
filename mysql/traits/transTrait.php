<?php
namespace database\mysql\traits;

trait transTrait
{
    public function startTrans()
    {
        $this->getCoreModel()->startTrans();
    }

    public function rollBack()
    {
        $this->getCoreModel()->rollBack();
    }

    public function commit()
    {
        $this->getCoreModel()->commit();
    }



}