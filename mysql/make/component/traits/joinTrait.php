<?php
namespace redb\mysql\make\component\traits;

trait joinTrait
{
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
        $this->partPresqlArr[] = $preSql;

        return $this;
    }

}