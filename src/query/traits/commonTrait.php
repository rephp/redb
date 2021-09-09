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
            //获取配置项
            if($this->configType=='master'){
                $config = current($this->config['master']);
            }else{
                shuffle($this->config['slave']);
                $config = current($this->config['slave']);
            }
            empty($config['charset']) && $config['charset'] = 'utf8';
            $options = array(
                \PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $config['charset'],
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            );
            if($config['presistent']){
                $options[PDO::ATTR_PERSISTENT] = true;
                //$this->initSystemPresistent();
            }
            $dsn = 'mysql:host='.$config['host'].';dbname='.$config['database'];
            $this->pdo = new \PDO($dsn, $config['username'], $config['password'], $options);
        }
        return $this;
    }

    protected function initSystemPresistent()
    {
        //由于mysql.allow_persistent在ini的配置等级为PHP_INI_SYSTEM表示可在 php.ini 或 httpd.conf 中设定
        //所以本处只做记录
        /*
         * 2 mysql -> my.cnf修改配置：

        [mysqld]

        interactive_timeout =60 // 交互连接(mysql-client)的过期时间。

        wait_timeout =30 // 长连接的过期时间时间。 这个一定要改啊！默认是8个小时。 如果请求量大点，很快连接数就占满了。

        max_connections = 100 //最大连接数，可以认为是连接池的大小

        3 php.ini 修改：

        [MySql]

        mysql.allow_persistent = On

        mysql.max_persistent = 99 // 要小于mysql配置的最大连接数

        mysql.max_links = 99

        4 webserver如果是apache ,需要启用keep-alive。 否则，一旦请求退出，长连接将无法再重用。

        webserver 是nginx的情况:

        pm = dynamic // 默认启动一些子进程，用于处理http请求。

        pm.max_children // 最大的子进程数。 这个配置要小于 mysql 的max_connections。

        5 如果发现还是不能用，请检查操作系统的keepalive 是否启用。

        综述：

        需要 keep-alive 和 数据库长连接同时启用，否则长连接回白白的占用mysql的连接数资源，而无法重用。

        对于 nginx + php-fpm 的情况，其实是保持了 php-fpm 子进程与mysql的长连接。 前端的http请求被分配给哪个 php-fpm子进程，该子进程就重用自己与mysql 的长连接。

                 */
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
        return $this->connect()->pdo;
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