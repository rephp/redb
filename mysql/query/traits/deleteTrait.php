<?php
namespace redb\mysql\query\traits;
/**
 * Trait deleteTrait
 * @package redb\mysql\query\traits
 * @method \PDOStatement  execute($preSql, $bindParams)
 */
trait deleteTrait
{

    public function delete($preSql, $bindParams=[])
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