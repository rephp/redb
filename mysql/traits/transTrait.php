<?php
namespace redb\mysql\traits;
/**
 * Trait transTrait
 * @package redb\mysql\traits
 * @method \redb\mysql\query\cmd getCmd()
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