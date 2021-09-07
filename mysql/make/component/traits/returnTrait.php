<?php
namespace redb\mysql\make\component\traits;

trait returnTrait
{
    public function getPreSql()
    {
        return $this->preSql;
    }

    public function getBindParams()
    {
        return $this->bindParams;
    }
}