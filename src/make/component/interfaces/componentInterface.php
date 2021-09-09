<?php
namespace rephp\redb\make\component\interfaces;

use rephp\redb\orm\ormModel;

interface componentInterface
{
    public function parseModelInfo(ormModel $model);

    public function getPreSql();

    public function getBindParams();

    public function makePreSql();
}