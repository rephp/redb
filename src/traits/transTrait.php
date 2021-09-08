<?php
namespace redb\traits;
/**
 * Trait transTrait
 * @package redb\traits
 * @method \redb\query\cmd getCmd()
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