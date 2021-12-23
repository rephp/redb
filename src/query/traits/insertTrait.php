<?php

namespace rephp\redb\query\traits;

use rephp\redb\query\log;

/**
 * Trait insertTrait
 * @package rephp\redb\query\traits
 * @method \PDOStatement  execute($preSql, $bindParams)
 * @method \PDO getPdo()
 * @method commonTrait setConfigType($type)
 */
trait insertTrait
{
    public function lastInsertId()
    {
        return $this->getPdo()->lastInsertId();
    }

    public function insertDeal($preSql, $bindParams = [])
    {
        $stmt = $this->setConfigType($type = 'master')->execute($preSql, $bindParams);
        if (!$stmt) {
            $stmt      = null;
            $errorInfo = log::getLastErrorLog();
            throw new \Exception($errorInfo['error']['msg'], $errorInfo['error']['code']);
        }

        $result = $stmt->rowCount();
        $stmt   = null;

        return $result;
    }

    public function insert($preSql, $bindParams = [])
    {
        $res    = $this->insertDeal($preSql, $bindParams);
        $result = $res ? $this->lastInsertId() : $res;

        return $result;
    }

    public function insertReplace($preSql, $bindParams = [])
    {
        return $this->insertDeal($preSql, $bindParams);
    }

    public function insertIgnore($preSql, $bindParams = [])
    {
        return $this->insertDeal($preSql, $bindParams);
    }

    public function batchInsert($preSql, $bindParams = [])
    {
        return $this->insertDeal($preSql, $bindParams);
    }

    public function batchInsertReplace($preSql, $bindParams = [])
    {
        return $this->insertDeal($preSql, $bindParams);
    }

    public function batchInsertIgnore($preSql, $bindParams = [])
    {
        return $this->insertDeal($preSql, $bindParams);
    }
}
