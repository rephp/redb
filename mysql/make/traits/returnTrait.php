<?php
namespace redb\mysql\make\traits;
use redb\mysql\orm\ormModel;

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