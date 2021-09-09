<?php
namespace rephp\redb\query\traits;
/**
 * Trait selectTrait
 * @package rephp\redb\query\traits
 * @method \PDOStatement  execute($preSql, $bindParams)
 */
trait selectTrait
{

    public function one($preSql, $bindParams=[])
    {
        $stmt = $this->execute($preSql, $bindParams);
        if(!$stmt){
            $stmt = null;
            return false;
        }

        $result = $stmt->fetch();
        $stmt = null;

        return $result;
    }

    public function all($preSql, $bindParams=[])
    {
        $stmt = $this->execute($preSql, $bindParams);
        if(!$stmt){
            $stmt = null;
            return false;
        }

        $result = $stmt->fetchAll();
        $stmt = null;

        return $result;
    }

    public function count($preSql, $bindParams=[])
    {
        $res = $this->one($preSql, $bindParams);
        return $res['num'];
    }
}