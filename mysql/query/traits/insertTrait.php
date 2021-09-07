<?php
namespace redb\mysql\query\traits;
/**
 * Trait insertTrait
 * @package redb\mysql\query\traits
 * @method \PDOStatement  execute($preSql, $bindParams)
 * @method \PDO getPdo()
 */

trait insertTrait
{

    public function insert($preSql, $bindParams=[])
    {
        $stmt = $this->execute($preSql, $bindParams);
        if(!$stmt){
            $stmt = null;
            return false;
        }

        $result = $this->getPdo()->lastInsertId();
        $stmt = null;

        return $result;
    }

    public function insertReplace($preSql, $bindParams=[])
    {
        return $this->insert($preSql, $bindParams);
    }

    public function insertIgnore($preSql, $bindParams=[])
    {
        return $this->insert($preSql, $bindParams);
    }

    public function batchInsert($preSql, $bindParams=[])
    {
        return $this->insert($preSql, $bindParams);
    }

    public function batchInsertReplace($preSql, $bindParams=[])
    {
        return $this->insert($preSql, $bindParams);
    }

    public function batchInsertIgnore($preSql, $bindParams=[])
    {
        return $this->insert($preSql, $bindParams);
    }

}