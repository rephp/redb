<?php
namespace redb\mysql\query\traits;
/**
 * Trait updateTrait
 * @package redb\mysql\query\traits
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