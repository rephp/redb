<?php
namespace redb\mysql\make\component\traits;

/**
 * Trait commonTrait
 * @package redb\mysql\make\traits
 * @property array $bindParams
 */

trait commonTrait
{

    /**
     * 过滤字段名，防止sql注入
     * @param string $column 列名
     * @return string
     */
    protected function filterColumn($column)
    {
        $replaceArr = [
            ' ', '%', '*', '\t', '\\', '/', '\'', '"', '#', ';', '$', '@', '!', '(', ')', '+', '-', '=',
        ];
        $column     = str_replace($replaceArr, '', $column);
        return $column;
    }

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
                    $preSql .= $currentOperate.$this->getColumnPreSql($item);
                    $firstItemFlag = false;
                    $currentOperate = ' and ';
                    break;
            }
        }
        $this->wherePreSql = $preSql;

        return $this;
    }

    protected function parseWhereItem($item)
    {
        //兼容跨库
        $item[0] = '`'.str_replace('.', '`.`', $item[0]).'` ';
        $result = '';
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



}