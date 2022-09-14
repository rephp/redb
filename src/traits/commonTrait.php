<?php

namespace rephp\redb\traits;

use rephp\redb\query\log;

/**
 * Trait commonTrait
 * @package rephp\redb\traits
 * @method  \rephp\redb\orm\ormModel getOrmModel()
 * @method \rephp\redb\query\cmd getCmd()
 */
trait commonTrait
{
    protected $client = [];

    /**
     * 主动断开数据库连接
     * @return \rephp\redb\query\cmd
     */
    public function close()
    {
        return $this->getCmd()->close();
    }

    /**
     * 数据库重连
     * @return \rephp\redb\query\cmd
     */
    public function reConnect()
    {
        return $this->getCmd()->close()->connect();
    }

    /**
     * 清空删除orm对象
     * @return $this
     */
    public function deleteOrmModel()
    {
        $this->ormModel = null;
        return $this;
    }

    /**
     * 开始运行，运行后自行清除历史查询痕迹
     * @return bool
     */
    public function run()
    {
        $result = $this->getCmd()->run($this->getOrmModel());
        $this->deleteOrmModel();
        return $result;
    }

    /**
     * 查询条件，支持多次where，默认连接方式是and
     * 如：
     * $this->where('id', 2, '=');
     * $this->where('id', 2, 'like');
     * $this->where('id', [2], 'in');
     * $this->where('id', [2,3], 'between');
     * $this->where('id', 'is null');
     * 其他更复杂写法有
     * $where = [
     *     'and',
     *      ['id', [2], 'in'],
     *      'or',
     *      '(',
     *      ['id', [2,3], 'between'],
     *      ')'
     * ];
     * $this->where($where);
     * ...等其他更多写法请看文档
     * @param mixed  $cloumn 查询字段或表达式
     * @param mixed  $value  查询值
     * @param string $opt    操作符
     * @return $this
     */
    public function where($cloumn, $value = '', $opt = '=')
    {
        if (is_array($cloumn)) {
            //判断是一维数组还是二维数组
            $isOneWhere = (count($cloumn) == count($cloumn, 1));
            //如果是一维数组,即意味着需要执行一个查询条件
            if ($isOneWhere) {
                //区分是传统模式还是新式定义格式
                $arrayKeyArr = array_keys($cloumn);
                if (is_numeric(current($arrayKeyArr))) {
                    $this->getOrmModel()->where($cloumn);
                    return $this;
                }
            }
            //如果是二维数组，意味着需要执行多个查询条件
            foreach ($cloumn as $key => $value) {
                if (is_array($value)) {
                    $tempWhere = $value;
                } else {
                    $tempWhere = is_numeric($key) ? [$value] : [$key, '=', $value];
                }
                $this->getOrmModel()->where($tempWhere);
            }
            return $this;
        }
        //否则就是老实巴交的规范查询
        $this->getOrmModel()->where([$cloumn, $opt, $value]);
        return $this;
    }

    /**
     * 向where条件追加一个or关键字
     * @return $this
     */
    public function whereOr()
    {
        $this->getOrmModel()->whereOr();
        return $this;
    }

    /**
     * 向where条件追加一个and关键字（平时操作默认为and）
     * @return $this
     */
    public function whereAnd()
    {
        $this->getOrmModel()->whereAnd();
        return $this;
    }

    /**
     * in句操作
     * @param string $column 字段名
     * @param array  $values 查询值
     * @return $this
     */
    public function whereIn($column, array $values)
    {
        $this->getOrmModel()->whereIn($column, $values);
        return $this;
    }

    /**
     * not in句操作
     * @param string $column 字段名
     * @param array  $values 查询值
     * @return $this
     */
    public function whereNotIn($column, array $values)
    {
        $this->getOrmModel()->whereNotIn($column, $values);
        return $this;
    }

    /**
     * like语句操作
     * @param string $column 字段名
     * @param string $value  搜索关键字
     * @return $this
     */
    public function whereLike($column, $value)
    {
        $this->getOrmModel()->whereLike($column, $value);
        return $this;
    }

    /**
     * not like语句操作
     * @param string $column 字段名
     * @param string $value  搜索关键字
     * @return $this
     */
    public function whereNotLike($column, $value)
    {
        $this->getOrmModel()->whereNotLike($column, $value);
        return $this;
    }

    /**
     * between语句操作
     * @param string $column 字段名
     * @param mixed  $min    最小值
     * @param mixed  $max    最大值
     * @return $this
     */
    public function whereBetween($column, $min, $max)
    {
        $this->getOrmModel()->whereBetween($column, $min, $max);
        return $this;
    }

    /**
     * not between语句操作
     * @param string $column 字段名
     * @param mixed  $min    最小值
     * @param mixed  $max    最大值
     * @return $this
     */
    public function whereNotBetween($column, $min, $max)
    {
        $this->getOrmModel()->whereNotBetween($column, $min, $max);
        return $this;
    }

    /**
     * is null操作
     * @param string $column 字段名
     * @return $this
     */
    public function whereIsNull($column)
    {
        $this->getOrmModel()->whereIsNull($column);
        return $this;
    }

    /**
     * not is null操作
     * @param string $column 字段名
     * @return $this
     */
    public function whereIsNotNull($column)
    {
        $this->getOrmModel()->whereIsNotNull($column);
        return $this;
    }

    /**
     * 联表查询时对主表的重命名
     * @param string $alias
     * @return $this
     */
    public function alias($alias = '')
    {
        $this->getOrmModel()->alias($alias);
        return $this;
    }

    /**
     * 左连接
     * @param string $tableName  关联的子表表名，含对子表的重命名如: 'product AS P'
     * @param string  $on on关联信息，如: 'A.id=B.pid'
     * @return $this
     */
    public function leftJoin($tableName, $on)
    {
        $this->getOrmModel()->leftJoin($tableName, $on);
        return $this;
    }

    /**
     * 右连接
     * @param string $tableName  关联的子表表名，含对子表的重命名如: 'product AS P'
     * @param string  $on on关联信息，如: 'A.id=B.pid'
     * @return $this
     */
    public function rightJoin($tableName, $on)
    {
        $this->getOrmModel()->rightJoin($tableName, $on);
        return $this;
    }

    /**
     * 内连接
     * @param string $tableName  关联的子表表名，含对子表的重命名如: 'product AS P'
     * @param string  $on on关联信息，如: 'A.id=B.pid'
     * @return $this
     */
    public function innerJoin($tableName, $on)
    {
        $this->getOrmModel()->innerJoin($tableName, $on);
        return $this;
    }

    /**
     * where条件追加左括号
     */
    public function whereLeftBracket()
    {
        $this->getOrmModel()->whereLeftBracket();
        return $this;
    }

    /**
     * where条件追加右边括号
     */
    public function whereRightBracket()
    {
        $this->getOrmModel()->whereRightBracket();
        return $this;
    }

    /**
     * 插入和修改时设置设置数据
     * @param array $data  插入和修改时设置的数据键值对一维数组
     * @return $this
     */
    public function data(array $data)
    {
        $this->getOrmModel()->data($data);
        return $this;
    }

    /**
     * 标记sql要执行的行为，以便后续处理和执行
     * @param $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->getOrmModel()->setAction($action);
        return $this;
    }

    /**
     * 获取最近一条执行的sql记录信息
     * @return string
     */
    public function getSql()
    {
        $lastSqlRes = log::getLastLog();
        return $lastSqlRes['sql'] . ' - 执行时间: ' . $lastSqlRes['time'] . ' 秒';
    }

    /**
     * 获取历史以来执行的所有sql
     * @return array
     */
    public function getLog()
    {
        return log::getAllLog();
    }

    /**
     * 获取历史以来执行的所有错误sql信息
     * @return array
     */
    public function getErrorLog()
    {
        return log::getAllErrorLog();
    }

    /**
     * 获取最近一条执行的sql记录信息
     * @return array
     */
    public function getLastLog()
    {
        return log::getLastLog();
    }

    /**
     * 获取历史以来执行的所有错误sql信息
     * @return array
     */
    public function getLastErrorLog()
    {
        return log::getLastErrorLog();
    }
}
