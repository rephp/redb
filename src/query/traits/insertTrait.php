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

    public function insert($preSql, $bindParams = [])
    {
        $stmt = $this->setConfigType($type = 'master')->execute($preSql, $bindParams);
        if (!$stmt) {
            $stmt = null;
            $errorInfo = log::getLastErrorLog();
            throw new \Exception($errorInfo['error']['msg'], $errorInfo['error']['code']);
        }

        $result = $this->getPdo()->lastInsertId();
        $stmt   = null;

        return $result;
    }

    public function insertReplace($preSql, $bindParams = [])
    {
        return $this->setConfigType($type = 'master')->insert($preSql, $bindParams);
    }

    public function insertIgnore($preSql, $bindParams = [])
    {
        return $this->setConfigType($type = 'master')->insert($preSql, $bindParams);
    }

    public function batchInsert($preSql, $bindParams = [])
    {
        return $this->setConfigType($type = 'master')->insert($preSql, $bindParams);
    }

    public function batchInsertReplace($preSql, $bindParams = [])
    {
        return $this->setConfigType($type = 'master')->insert($preSql, $bindParams);
    }

    public function batchInsertIgnore($preSql, $bindParams = [])
    {
        return $this->setConfigType($type = 'master')->insert($preSql, $bindParams);
    }

}