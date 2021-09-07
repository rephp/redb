<?php
namespace redb\mysql\make\component;


use redb\mysql\make\traits\returnTrait;
use redb\mysql\make\traits\joinTrait;
use redb\mysql\make\traits\commonTrait;
use redb\mysql\orm\ormModel;

class update
{
    protected $preSql;
    protected $wherePreSql;
    protected $bodyPreSql;
    protected $joinPreSql;
    protected $bindParams = [];
    protected $dataPreSql;

    use returnTrait, joinTrait, commonTrait;

    public function parseModelInfo(ormModel $model)
    {
        $where   = $model->getWhere();
        $joinArr = $model->getJoin();
        $table   = $model->getTable();
        $alias   = $model->getAlias();
        $data    = $model->getData();

        return $this->parseBody($table, $alias)->parseData($data)->parseWhere($where)->parseJoin($joinArr)->makePreSql();
    }

    protected function parseData($data=[])
    {
        if(empty($data)){
            return false;
        }
        $data = (array)$data;
        $preSqlArr = [];
        foreach($data as $key=>$value){
            $preSql[] = $key.'='.$value;
        }
        $this->dataPreSql = implode(',', $preSqlArr);

        return true;
    }

    protected function parseBody($table, $alias='')
    {
        $preSql      = 'UPDATE `' . $table . '` ';
        empty($alias) || $preSql .= 'ALIAS '.$alias;
        $this->bodyPreSql = $preSql;

        return $this;
    }

    protected function makePreSql()
    {
        $preSql = $this->bodyPreSql;
        empty($this->joinPreSql) || $preSql .= ' '.$this->joinPreSql;
        $preSql .= ' SET '.$this->dataPreSql;
        empty($this->wherePreSql) || $preSql .= ' WHERE '.$this->wherePreSql;
        $this->preSql = $preSql;

        return $this;
    }

}