<?php
namespace rephp\redb\query\traits;
/**
 * Trait transTrait
 * @package rephp\redb\query\traits
 * @method \PDO getDb()
 */
trait transTrait
{
    public function startTrans()
    {
        $this->getDb()->beginTransaction();
        return $this;
    }

    public function rollBack()
    {
        $this->getDb()->rollBack();
        return $this;
    }

    public function commit()
    {
        $this->getDb()->commit();
        return $this;
    }



}