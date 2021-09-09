<?php
namespace rephp\redb\query\traits;
use rephp\redb\query\cmd;

/**
 * Trait deleteTrait
 * @package rephp\redb\query\traits
 * @method \PDOStatement  execute($preSql, $bindParams)
 * @method cmd setConfigType($type)
 */
trait deleteTrait
{

    public function delete($preSql, $bindParams=[])
    {
        $stmt = $this->setConfigType($type='master')->execute($preSql, $bindParams);
        if(!$stmt){
            $stmt = null;
            return false;
        }

        $result = $stmt->rowCount();
        $stmt = null;

        return $result;
    }

}