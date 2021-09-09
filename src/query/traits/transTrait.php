<?php

namespace rephp\redb\query\traits;

use rephp\redb\query\cmd;

/**
 * Trait transTrait
 * @package rephp\redb\query\traits
 * @method \PDO getDb()
 * @method cmd setConfigType($type)
 */
trait transTrait
{
    public function startTrans()
    {
        $this->setConfigType($type = 'master')->getDb()->beginTransaction();
        return $this;
    }

    public function rollBack()
    {
        $this->setConfigType($type = 'master')->getDb()->rollBack();
        return $this;
    }

    public function commit()
    {
        $this->setConfigType($type = 'master')->getDb()->commit();
        return $this;
    }


}