<?php

namespace rephp\redb\query\traits;

/**
 * Trait transTrait
 * @package rephp\redb\query\traits
 * @method \PDO getPdo()
 * @method commonTrait setConfigType($type)
 */
trait transTrait
{
    public function startTrans()
    {
        $this->setConfigType($type = 'master')->getPdo()->beginTransaction();
        return $this;
    }

    public function rollBack()
    {
        $this->setConfigType($type = 'master')->getPdo()->rollBack();
        return $this;
    }

    public function commit()
    {
        $this->setConfigType($type = 'master')->getPdo()->commit();
        return $this;
    }
}
