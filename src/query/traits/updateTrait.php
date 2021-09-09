<?php

namespace rephp\redb\query\traits;

use rephp\redb\query\cmd;

/**
 * Trait updateTrait
 * @package rephp\redb\query\traits
 * @method \PDOStatement  execute($preSql, $bindParams)
 * @method cmd setConfigType($type)
 */
trait updateTrait
{

    public function update($preSql, $bindParams = [])
    {

        $stmt = $this->setConfigType($type = 'master')->execute($preSql, $bindParams);
        if (!$stmt) {
            $stmt = null;
            return false;
        }

        $result = $stmt->setConfigType($type = 'master')->rowCount();
        $stmt   = null;

        return $result;
    }

}