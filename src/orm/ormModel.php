<?php
namespace rephp\redb\orm;

use rephp\redb\make\maker;

/**
 * ormModel 核心orm类
 * @package rephp\redb\orm
 */
class ormModel
{
    protected $page    = 0;
    protected $limit   = 0;
    protected $data    = [];
    protected $where   = [];
    protected $incList = [];
    protected $action;
    protected $alias;
    protected $join    = [];
    protected $union   = [];
    protected $orderBy;
    protected $groupBy;
    protected $having;
    protected $select;
    protected $lock    = false;

    /**
     * 获取sql创建者
     * @return maker
     */
    protected function maker()
    {
        return new maker($this);
    }

    /**
     * 获取所有查询条件
     * @return array
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * 快速创建一条查询条件(默认为and)
     * @param  array $where 查询条件
     * @return $this
     */
    public function where($where)
    {
        $this->where[] = $where;
        return $this;
    }

    /**
     * 向where条件追加一个or关键字
     * @return $this
     */
    public function whereOr()
    {
        $this->where[] = ['OR'];
        return $this;
    }

    /**
     * 向where条件追加一个and关键字（默认可隐式自动产生and关键字）
     * @return $this
     */
    public function whereAnd()
    {
        $this->where[] = ['AND'];
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
        $this->where[] = [$column, 'IN', $values];
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
        $this->where[] = [$column, 'NOT IN', $values];
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
        $this->where[] = [$column, 'LIKE', $value];
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
        $this->where[] = [$column, 'NOT LIKE', $value];
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
        $this->where[] = [$column, 'BETWEEN', [$min, $max]];
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
        $this->where[] = [$column, 'NOT BETWEEN', [$min, $max]];
        return $this;
    }

    /**
     * is null操作
     * @param string $column 字段名
     * @return $this
     */
    public function whereIsNull($column)
    {
        $this->where[] = [$column, 'IS NULL'];
        return $this;
    }

    /**
     * not is null操作
     * @param string $column 字段名
     * @return $this
     */
    public function whereIsNotNull($column)
    {
        $this->where[] = [$column, 'IS NOT NULL'];
        return $this;
    }

    /**
     * innodb引擎查询单条数据（执行one方法）时，可锁定行
     * @param bool $isLock
     * @return $this
     */
    public function lock($isLock = false)
    {
        $this->lock = $isLock;
        return $this;
    }

    /**
     * 获取行锁信息
     * @return bool
     */
    public function getLock()
    {
        return $this->lock;
    }

    /**
     * 左括号
     */
    public function whereLeftBracket()
    {
        $this->where[] = ['('];
        return $this;
    }

    /**
     * 右边括号
     */
    public function whereRightBracket()
    {
        $this->where[] = [')'];
        return $this;
    }

    /**
     * 插入和修改时设置设置数据
     * @param array $data  插入和修改时设置的数据键值对一维数组
     * @return $this
     */
    public function data(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 插入或者修改时获取数据信息
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 自增
     * @param string $column 字段名
     * @param int    $step   自增步长（正正数或者正浮点数）
     * @return $this
     */
    public function inc($column, $step = 1)
    {
        $this->incList[] = ['type' => 'inc', 'column' => $column, 'step' => $step];
        return $this;
    }

    /**
     * 自减
     * @param string $column 字段名
     * @param int    $step   自增步长（正正数或者正浮点数）
     * @return $this
     */
    public function dec($column, $step = 1)
    {
        $this->incList[] = ['type' => 'dec', 'column' => $column, 'step' => $step];
        return $this;
    }

    /**
     * 获取自增或者自减信息列表
     * @return array
     */
    public function getIncList()
    {
        return $this->incList;
    }

    /**
     * 标记sql要执行的行为，以便后续处理和执行
     * @param $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * 获取action标记信息
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * 设置数据表
     * @param  string $table  数据表名字
     * @return $this
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * 获取数据表名
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * 设置页数
     * @param int $page 页数
     * @return $this
     */
    public function page($page = 0)
    {
        $page = (int)$page;
        ($page < 1) && $page = 0;
        $this->page = $page;
        return $this;
    }

    /**
     * 获取页码数
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * 设置每页数据量
     * @param int $pageSize  每页多少条数据
     * @return $this
     */
    public function limit($pageSize = 0)
    {
        $pageSize = (int)$pageSize;
        ($pageSize < 1) && $pageSize = 0;
        $this->limit = $pageSize;
        return $this;
    }

    /**
     * 获取每页数量配置
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * 联表查询时对主表的重命名
     * @param string $alias
     * @return $this
     */
    public function alias($alias = '')
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * 获取主表alias名字
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * 左连接
     * @param string $tableName  关联的子表表名，含对子表的重命名如: 'product AS P'
     * @param string  $on on关联信息，如: 'A.id=B.pid'
     * @return $this
     */
    public function leftJoin($tableName, $on)
    {
        $this->join[] = ['LEFT JOIN', $tableName, $on];
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
        $this->join[] = ['RIGHT JOIN', $tableName, $on];
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
        $this->join[] = ['INNER JOIN', $tableName, $on];
        return $this;
    }

    /**
     * 获取所有表连接信息
     * @return array
     */
    public function getJoin()
    {
        return $this->join;
    }

    /**
     * union联合查询
     * @param ormModel $model  ormModel对象
     * @return $this
     */
    public function union(ormModel $model)
    {
        $model->limit(0)->page(0)->setAction('all');
        $this->union[] = ['type' => 'UNION', 'model' => $model];
        return $this;
    }

    /**
     * union all联合查询
     * @param ormModel $model  ormModel对象
     * @return $this
     */
    public function unionAll(ormModel $model)
    {
        $model->limit(0)->page(0)->setAction('all');
        $this->union[] = ['type' => 'UNION ALL', 'model' => $model];
        return $this;
    }

    /**
     * 获取所有联合查询信息
     * @return array
     */
    public function getUnion()
    {
        return $this->union;
    }

    /**
     * 排序
     * @param string $orderBy 排序字符串如'cate_id ASC,id DESC'
     * @return $this
     */
    public function orderBy($orderBy = '')
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * 获取排序信息
     * @return mixed
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * group语句
     * @param string $groupBy group语句（不含group by字样，如'cate_id'）
     * @return $this
     */
    public function groupBy($groupBy = '')
    {
        $this->groupBy = $groupBy;
        return $this;
    }

    /**
     * 获取group by 信息
     * @return mixed
     */
    public function getGroupBy()
    {
        return $this->groupBy;
    }

    /**
     * having语句
     * @param string $groupBy having语句（不含having字样，如'num>2'）
     * @return $this
     */
    public function having($having = '')
    {
        $this->having = $having;
        return $this;
    }

    /**
     * 获取having信息
     * @return mixed
     */
    public function getHaving()
    {
        return $this->having;
    }

    /**
     * 设置查询语句中的select部分
     * @param  string  $selectRawString  select内容，如'id,title,create_time'或者'*'
     * @return $this
     */
    public function select($select)
    {
        $this->select = $select;
        return $this;
    }

    /**
     * 获取select信息
     * @return mixed
     */
    public function getSelect()
    {
        return $this->select;
    }

    /**
     * 获取执行的sql语句
     * @return string
     */
    public function getSql()
    {
        $preSql     = $this->getPresql();
        $bindParams = $this->getBindParams();
        return vsprintf(str_replace('?', '\'%s\'', $preSql), $bindParams);
    }

    /**
     * 获取presql
     * @return mixed
     */
    public function getPresql()
    {
        return $this->maker()->getPresql();
    }

    /**
     * 获取绑定参数
     * @return mixed
     */
    public function getBindParams()
    {
        return $this->maker()->getBindParams();
    }
}
