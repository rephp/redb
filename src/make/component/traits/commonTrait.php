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
        if (empty($where)) {
            return $this;
        }

        $currentOperate = '';
        foreach ($where as $item) {
            if (empty($item)) {
                continue;
            }
            in_array('WHERE', $this->partPreSqlArr) || $this->partPreSqlArr[] = 'WHERE';
            switch (strtolower($item[0])) {
                case 'and':
                    $currentOperate = ' AND ';
                    break;
                case 'or':
                    $currentOperate = ' OR ';
                    break;
                case '(':
                    $this->partPreSqlArr[] = $currentOperate.'(';
                    $currentOperate = '';
                    break;
                case ')':
                    $this->partPreSqlArr[] = ')';
                    break;
                default:
                    $preSql = $currentOperate.$this->parseWhereItem($item);
                    $currentOperate = ' AND ';
                    empty($preSql) || $this->partPreSqlArr[] = $preSql;
                    break;
            }
        }

        return $this;
    }

    protected function parseWhereItem($item)
    {
        //兼容跨库
        $item[0] = '`'.str_replace('.', '`.`', $item[0]).'` ';
        $case = str_replace(' ', '', strtolower($item[1]));
        $case = str_replace('\t', '', $case);
        switch ($case) {
            case 'in':
            case 'notin':
                is_array($item[2]) || $item[2]  = explode(',', $item[2]);
                foreach ($item[2] as $val) {
                    $this->bindParams[] = $val;
                    $tempArr[] = '?';
                }
                $result = $item[0].$item[1] . ' ('.implode(',', $tempArr).')';
                break;
            case 'like':
            case 'notlike':
                $result = $item[0].$item[1] .' ?';
                $this->bindParams[] = '%'.$item[2].'%';
                break;
            case 'between':
            case 'notbetween':
                is_array($item[2]) || $item[2]  = explode(',', $item[2]);
                $startValue = current($item[2]);
                $endValue = end($item[2]);
                $result = '('.$item[0].$item[1] .' ? AND ?)';
                $this->bindParams[] = $startValue;
                $this->bindParams[] = $endValue;
                break;
            case 'isnull':
            case 'isnotnull':
                $result = $item[0].$item[1];
                break;
            default://运算符
                $result = $item[0].$item[1].' ?';
                $this->bindParams[] = $item[2];
                break;
        }

        return $result;
    }

    public function makePreSql()
    {
        $this->preSql = implode(' ', $this->partPreSqlArr);
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
