<?php
namespace rephp\redb\make\component\traits;

/**
 * Trait commonTrait
 * @package rephp\redb\make\traits
 * @property array $bindParams
 */

trait commonTrait
{
    protected function parseWhere($where)
    {
        if(empty($where)){
            return $this;
        }
        $currentOperate = '';
        $preSql = '';
        $firstItemFlag = true;
        foreach ($where as $item) {
            if(empty($item)){
                continue;
            }
            switch (strtolower($item[0])){
                case 'and':
                    $currentOperate = ' and ';
                    break;
                case 'or':
                    $currentOperate = ' or ';
                    break;
                case '(':
                    $preSql .= $currentOperate.'(';
                    $firstItemFlag = true;
                    break;
                case ')':
                    $preSql .= ')';
                    break;
                default:
                    $firstItemFlag && $currentOperate = '';
                    $preSql .= $currentOperate.$this->parseWhereItem($item);
                    $firstItemFlag = false;
                    $currentOperate = ' and ';
                    break;
            }
        }
       empty($preSql) || $this->partPreSqlArr[] = 'WHERE '.$preSql;

        return $this;
    }

    protected function parseWhereItem($item)
    {
        //兼容跨库
        $item[0] = '`'.str_replace('.', '`.`', $item[0]).'` ';
        $case = str_replace(' ', '', strtolower($item[1]));
        $case = str_replace('\t', '', $case);
        switch ($case){
            case 'in':
            case 'notin':
                is_array($item[2]) || $item[2]  = explode(',', $item[2]);
                $result = $item[0].$item[1] . ' ('.implode(',', $item[2]).')';
                $this->bindParams = array_merge($this->bindParams, $item[2]);
                break;
            case 'like':
            case 'notlike':
                $result = $item[0].$item[1] .' \'%?%\'';
                $this->bindParams[] = $item[2];
                break;
            case 'between':
            case 'notbetween':
                is_array($item[2]) || $item[2]  = explode(',', $item[2]);
                $startValue = current($item[2]);
                $endValue = end($item[2]);
                is_numeric($startValue) || $startValue = '\''.$startValue.'\'';
                is_numeric($endValue) || $endValue = '\''.$endValue.'\'';
                $result = '('.$item[0].$item[1] .' ? AND ?)';
                $this->bindParams[] = $startValue;
                $this->bindParams[] = $endValue;
                break;
            case 'isnull':
            case 'isnotnull':
                $result = $item[0].$item[1];
                break;
            default://运算符
                is_numeric($item[2]) || $item[2] = '\''.$item[2].'\'';
                $result = $item[0].$item[1].' ?';
                $this->bindParams[] = $item[2];
                break;
        }

        return $result;
    }

    public function makePreSql()
    {
        $preSql = '';
        foreach($this->partPreSqlArr as $item){
            $preSql .= ' '.$item;
        }
        $this->preSql = $preSql;

        return $this;
    }

    public function getPreSql()
    {
        return $this->preSql;
    }

    public function getBindParams()
    {
        return $this->bindParams;
    }

}