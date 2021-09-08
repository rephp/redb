<?php
namespace redb\make\component\interfaces;

use redb\orm\ormModel;

interface componentInterface
{
    public function parseModelInfo(ormModel $model);

    public function getPreSql();

    public function getBindParams();

    public function makePreSql();
}