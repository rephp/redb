<?php
namespace redb\mysql\make\component;
use redb\mysql\make\lib\lib;
use redb\mysql\orm\ormModel;

class delete
{
    protected $preSql;
    protected $wherePreSql;
    protected $bodyPreSql;
    protected $joinPreSql;
    protected $bindParams = [];

    public function parseModelInfo(ormModel $model)
    {
        $where = $model->getWhere();
        foreach($where as $item){
            $this->bindParams[] = $item['value'];
        }

        return $this;
    }

    public function deal(ormModel $model)
    {
        $table = $model->getTable();
        $preSql      = 'DELETE FROM `' . $table . '` ';
        $wherePreSql = lib::formatWherePreSql($where);
        empty($wherePreSql) || $preSql .= ' WHERE ' . $wherePreSql;

        return $preSql;
    }
    public static function getWherePreSql($where)
    {
            //            //1.and, or, ()    //2.(not)in,(not)like,(not)isnull,（=><）,(not)BETWEEN
//            ['and', ['column', '=', '333']],
//            ['('],
//                ['and', ['column', '=', '333']],
//                ['or', ['column', 'in', ['333']]],
//                ['and', ['column', 'in', '333,33']],
//                ['and', ['column', 'like', '333,33']],
//                 ['and', ['column', 'BETWEEN', '333,33']],
//                 ['and', ['column', 'isnull']],
//            [')'],

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
                    $preSql .= $currentOperate.self::getColumnPreSql($item);
                    $firstItemFlag = false;
                    $currentOperate = ' and ';
                    break;
            }
        }

        return $preSql;
    }

    public static function getColumnPreSql($item)
    {
        //兼容跨库
        $item[0] = '`'.str_replace('.', '`.`', $item[0]).'` ';
        if(!isset($item[2])){
            return $item[0].$item[1];
        }
        $result = '';
        $case = str_replace(' ', '', strtolower($item[1]));
        $case = str_replace('\t', '', $case);
        switch ($case){
            case 'in':
            case 'notin':
                is_array($item[2]) || $item[2]  = explode(',', $item[2]);
                $result = $item[0].$item[1] . ' (\''.implode('\',\'', $item[2]).'\')';
                break;
            case 'like':
            case 'notlike':
                $result = $item[0].$item[1] .' \'%'.$item[2].'%\'';
                break;
            case 'between':
            case 'notbetween':
                is_array($item[2]) || $item[2]  = explode(',', $item[2]);
                $startValue = current($item[2]);
                $endValue = end($item[2]);
                is_numeric($startValue) || $startValue = '\''.$startValue.'\'';
                is_numeric($endValue) || $endValue = '\''.$endValue.'\'';
                $result = '('.$item[0].$item[1] .' '.$startValue.' AND '.$endValue.')';
                break;
            case 'isnull':
            case 'isnotnull':
                $result = $item[0].$item[1];
                break;
            default://运算符
                is_numeric($item[2]) || $item[2] = '\''.$item[2].'\'';
                $result = $item[0].$item[1].' '.$item[2];
                break;
        }

        return $result;
    }

}