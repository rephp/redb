<?php
namespace redb\mysql\query\traits;
/**
 * Trait transTrait
 * @package redb\mysql\query\traits
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