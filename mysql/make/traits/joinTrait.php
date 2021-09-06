<?php
namespace redb\mysql\make\traits;
use redb\mysql\orm\ormModel;

trait joinTrait
{
//DELETE  alias FROM test AS alias LEFT JOIN test_copy ON test.`ttile`=test_copy.`ttile` WHERE test_copy.id=1;
//DELETE test FROM test WHERE ttile='test';

    protected function parseJoin($joinArr)
    {
        if(empty($joinArr)){
            return $this;
        }
        $preSql = '';
        foreach($joinArr as $item){
            if(empty($item)){
                continue;
            }
            $preSql .= $item[0].' '.$item[1] .' ON '.$item[2];
        }
        $this->joinPreSql = $preSql;

        return $this;
    }

}