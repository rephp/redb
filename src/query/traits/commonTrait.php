<?php
namespace rephp\redb\query\traits;

use rephp\redb\query\log;

trait commonTrait
{

    public function close()
    {
        $this->pdo  = null;
        return $this;
    }

    public function connect()
    {
        if(!$this->pdo){
            $options = array(
                \PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->charset,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            );
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->database;
            $this->pdo = new \PDO($dsn, $this->username, $this->password, $options);
        }
        return $this;
    }

    public function reConnect()
    {
        return $this->close()->connect();
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
            $pdo = $this->getDb()->prepare($preSql);
            //绑定参数到预处理对象
            $index = 1;
            foreach($params as $fileld => $value){
                $pdo->bindValue($index, $value);
                $index++;
            }
            //执行命令
            $stmt = $pdo->execute();
            log::setLog(vsprintf(str_replace('?', '%s', $preSql), $params), round(microtime(true) - $startTime, 6));
            $pdo = null;
            return $stmt;

        }catch (\Exception $e) {
            //其他情况记录mysql错误日志
            $extErrorInfo = [
                'code' => $e->getCode(),
                'msg'  => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
            log::setErrorLog(vsprintf($preSql, $params), round(microtime(true) - $startTime, 6), $extErrorInfo);
        }

        return false;
    }

}