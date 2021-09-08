<?php
namespace redb\query\traits;
/**
 * Trait deleteTrait
 * @package redb\query\traits
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