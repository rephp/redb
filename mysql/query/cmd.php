<?php

namespace redb\mysql\query;

use redb\mysql\ormModel;
use redb\mysql\query\traits\selectTrait;
use redb\mysql\query\traits\insertTrait;
use redb\mysql\query\traits\updateTrait;
use redb\mysql\query\traits\deleteTrait;
use redb\mysql\query\traits\transTrait;

class cmd
{
    use insertTrait, deleteTrait, updateTrait, selectTrait, transTrait;

    /**
     * @var pdo链接
     */
    protected $pdo;

    public function __construct($host='127.0.0.1', $port=3389, $username='', $password='')
    {
        $this->host     = $host;
        $this->port     = $port;
        $this->username = $username;
        $this->password = $password;
    }


    public function close()
    {
        $this->pdo  = null;
        return $this;
    }

    public function connect()
    {
        if(!$this->pdo){
            $options = array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->charset,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            );
            $this->pdo = new \PDO($this->dsn, $this->username, $this->password, $options);
        }
        return $this;
    }

    public function reConnection()
    {
        return $this->close()->connection();
    }

    /**
     * @return \PDO pdo链接
     */
    public function getDb()
    {
        return $this->pdo;
    }

    /**
     * @param   string    $preSql
     * @param array $params
     * @return \PDOStatement
     */
    public function execute($preSql, $params=[])
    {
        $startTime = microtime(true);
        try{
            //创建pdo预处理对象
            $stmt = $this->getDb()->prepare($preSql);
            //绑定参数到预处理对象
            foreach($params as $fileld => $value){
                $stmt->bindValue(':'.$fileld,$value);
            }
            //执行命令
            $res = $stmt->execute();
            log::setLog($preSql, round(microtime(true) - $startTime, 6));
            $stmt = null;
            return $res;

        }catch (\Exception $e) {
            //其他情况记录mysql错误日志
            $extErrorInfo = [
                'code' => $e->getCode(),
                'msg'  => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
            log::setErrorLog($preSql, round(microtime(true) - $startTime, 6), $extErrorInfo);
        }

        return false;
    }


    public function run(ormModel $model)
    {
        //1.获取要生成要执行的query类名字
        $action = $model->getAction();
        if (!method_exists($this, $action)) {
            return false;
        }
        //2.执行并返回结果
        try {
            $sql        = $model->getPreSql();
            $bindParams = $model->getBindParams();
            return $this->$action($sql, $bindParams);
        } catch (\Exception $e) {
            if (($e instanceof \yii\db\Exception) == true) {
                $offset_1         = stripos($e->getMessage(), 'MySQL server has gone away');
                $offset_2         = stripos($e->getMessage(), 'Lost connection to MySQL server');
                $offset_3         = stripos($e->getMessage(), 'Error while sending QUERY packet');
                $mysql_error_list = [
                    2006,//MySQL server has gone away
                    2013,//Lost connection to MySQL server
                    1040,//已到达数据库的最大连接数，请加大数据库可用连接数
                    1043,//无效连接
                    1081,//不能建立Socket连接
                    1158,//网络错误，出现读错误，请检查网络连接状况
                    1159,//网络错误，读超时，请检查网络连接状况
                    1160,//网络错误，出现写错误，请检查网络连接状况
                    1161,//网络错误，写超时，请检查网络连接状况
                    1203,//当前用户和数据库建立的连接已到达数据库的最大连接数，请增大可用的数据库连接数或重启数据库
                    1205,//加锁超时
                ];
                if ($offset_1 || $offset_2 || $offset_3 || in_array($e->errorInfo[1], $mysql_error_list)) {
                    $this->reConnection();
                    return $this->$action($sql);
                }
            }

        }

        return false;
    }

}