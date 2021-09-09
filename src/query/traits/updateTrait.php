<?php
namespace rephp\redb\query\traits;
/**
 * Trait updateTrait
 * @package rephp\redb\query\traits
 * @method \PDOStatement  execute($preSql, $bindParams)
 */
trait updateTrait
{

    public function update($preSql, $bindParams=[])
    {

        $stmt = $this->execute($preSql, $bindParams);
        if(!$stmt){
            $stmt = null;
            return false;
        }

        $result = $stmt->rowCount();
        $stmt = null;

        return $result;
    }

}