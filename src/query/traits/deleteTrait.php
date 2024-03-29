<?php

namespace rephp\redb\query\traits;

use rephp\redb\query\log;

/**
 * Trait deleteTrait
 * @package rephp\redb\query\traits
 * @method \PDOStatement  execute($preSql, $bindParams)
 * @method commonTrait setConfigType($type)
 */
trait deleteTrait
{
    public function delete($preSql, $bindParams = [])
    {
        $stmt = $this->setConfigType($type='master')->execute($preSql, $bindParams);
        if (!$stmt) {
            $stmt = null;
            $errorInfo = log::getLastErrorLog();
            throw new \Exception($errorInfo['error']['msg'], $errorInfo['error']['code']);
        }

        $result = $stmt->rowCount();
        $stmt = null;

        return $result;
    }
}
