<?php
namespace redb\mysql\make\component;
use redb\mysql\make\lib\lib;
use redb\mysql\orm\ormModel;

class delete
{
    protected $preSql;
    protected $bindParams = [];

    public function deal(ormModel $model)
    {
        $where = $model->getWhere();
        foreach($where as $item){
            $this->bindParams[] = $item['value'];
        }

        return $this;
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
        foreach ($where as $item) {
            $tempOperate = (empty($currentOperate) ? '' : 'and');
            switch (strtolower($item[0])) {
                case 'and':
                    $preSql         .= $tempOperate . self::getColumnPreSql($item);
                    $currentOperate = 'and';
                    break;
                case 'or':
                    $preSql         .= $tempOperate . self::getColumnPreSql($item);
                    $currentOperate = 'or';
                    break;
                case '(':
                    $preSql         .= $tempOperate . '(';
                    $currentOperate = '';
                    break;
                case ')':
                    $preSql         .= $tempOperate . ')';
                    $currentOperate = 'and';
                    break;
            }
        }
    }

    public static function getColumnPreSql($item)
    {

        if(!isset($item[2])){
            return '`'.$item[0].'` '.$item[1];
        }
        $result = '';
        switch (strtolower($item[1])){
            case 'in':
            case 'not in':
                is_array($item[2]) || $item[2]  = explode(',', $item[2]);
                $result = '`'.$item[0].'` '.$item[1] . ' (\''.implode('\',\'', $item[2]).'\')';
                break;
            case 'like':
            case 'not like':
                $result = '`'.$item[0].'` '.$item[1] .' \'%'.$item[2].'%\'';
                break;
            case 'between':
            case 'not between':
                is_array($item[2]) || $item[2]  = explode(',', $item[2]);
                $startValue = current($item[2]);
                $endValue = end($item[2]);
                is_numeric($startValue) || $startValue = '\''.$startValue.'\'';
                is_numeric($endValue) || $endValue = '\''.$endValue.'\'';
                $result = '(`'.$item[0].'` '.$item[1] .' '.$startValue.' AND '.$endValue.')';
                break;
            default:
                is_numeric($item[2]) || $item[2] = '\''.$item[2].'\'';
                $result = '`'.$item[0].'`'.$item[1] .$item[2];
                break;
        }

        return $result;
    }

    /**
     * 生成删除presql语句
     * @return string
     */
    public function getPreSql(ormModel $model)
    {
        $table = $model->getTable();
        $preSql      = 'DELETE FROM `' . $table . '` ';
        $wherePreSql = lib::formatWherePreSql($where);
        empty($wherePreSql) || $preSql .= ' WHERE ' . $wherePreSql;

        return $preSql;
    }

    public function getPreParams($where)
    {
        return $this->bindParams;
    }

}