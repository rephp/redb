<?php
namespace rephp\database\mysql\traits;

trait transTrait
{
    public function startTrans()
    {
        $this->getCmd()->startTrans();
    }

    public function rollBack()
    {
        $this->getCmd()->rollBack();
    }

    public function commit()
    {
        $this->getCmd()->commit();
    }



}