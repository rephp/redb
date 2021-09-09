<?php
namespace rephp\redb\traits;
/**
 * Trait transTrait
 * @package rephp\redb\traits
 * @method \rephp\redb\query\cmd getCmd()
 */
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