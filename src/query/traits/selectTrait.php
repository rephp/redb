<?php

namespace rephp\redb\query\traits;

use rephp\redb\query\cmd;

/**
 * Trait selectTrait
 * @package rephp\redb\query\traits
 * @method \PDOStatement  execute($preSql, $bindParams)
 * @method cmd setConfigType($type)
 */
trait selectTrait
{

    public function one($preSql, $bindParams = [])
    {
        $stmt = $this->setConfigType($type = 'slave')->execute($preSql, $bindParams);
        if (!$stmt) {
            $stmt = null;
            return false;
        }

        $result = $stmt->fetch();
        $stmt   = null;

        return $result;
    }

    public function all($preSql, $bindParams = [])
    {
        $stmt = $this->setConfigType($type = 'slave')->execute($preSql, $bindParams);
        if (!$stmt) {
            $stmt = null;
            return false;
        }

        $result = $stmt->fetchAll();
        $stmt   = null;

        return $result;
    }

    public function count($preSql, $bindParams = [])
    {
        $res = $this->setConfigType($type = 'slave')->one($preSql, $bindParams);
        return $res['num'];
    }
}