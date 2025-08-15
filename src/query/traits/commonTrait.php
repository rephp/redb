<?php

namespace rephp\redb\query\traits;

use rephp\redb\query\log;
use rephp\redb\orm\ormModel;

trait commonTrait
{
    /**
     * 设置数据库主从
     * @param string $type  数据库主从标识符
     * @return $this
     */
    public function setConfigType($type = 'master')
    {
        $type = strtolower($type);
        if ($type != 'master') {
            //如果设置的是从库读，则判断配置项是否有此配置，如果没此配置仍然切换为master
            $isExistSlave = isset($this->config['slave']) && !empty($this->config['slave']);
            $isExistSlave || $type = 'master';
        }
        $this->configType = $type;
        return $this;
    }

    /**
     * 断开mysql数据库连接
     * @return $this
     */
    public function close()
    {
        $this->pdo = null;
        return $this;
    }

    /**
     * 连接mysql数据库
     * @return $this
     */
    public function connect()
    {
        if (!$this->pdo) {
            //获取配置项
            if ($this->configType == 'master') {
                $config = current($this->config['master']);
            } else {
                shuffle($this->config['slave']);
                $config = current($this->config['slave']);
            }

            $config['debug'] = filter_var($config['debug'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            $this->debug     = (bool)$config['debug'];
            empty($config['charset']) && $config['charset'] = 'utf8';
            $options = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $config['charset'],
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ];
            if ($config['persistent']) {
                $options[\PDO::ATTR_PERSISTENT] = true;
                //$this->initSystemPresistent();
            }
            $dsn       = 'mysql:host=' . $config['host'] . ';dbname=' . $config['database'];
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

    /**
     * 重新连接mysql数据库
     * @return commonTrait
     */
    public function reConnect()
    {
        return $this->close()->connect();
    }

    /**
     * @return \PDO pdo链接
     */
    public function getPdo()
    {
        return $this->connect()->pdo;
    }

    /**
     * 触发执行运行入口
     * @param ormModel $model orm模型对象
     * @return bool
     * @throws \Exception
     */
    public function run(ormModel $model)
    {
        //1.获取要生成要执行的query类名字
        $action = $model->getAction();
        if (!method_exists($this, $action)) {
            return false;
        }

        //2.执行并返回结果
        try {
            $sql        = $model->getPresql();
            $bindParams = $model->getBindParams();
            return $this->$action($sql, $bindParams);
        } catch (\Exception $e) {
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
                return $this->reConnect()->$action($sql, $bindParams);
            }
            throw $e;
        }

        return false;
    }

    /**
     * 判断原生态sql的执行类型
     * @param string $sql 原生sql
     * @return string
     */
    protected function getRawAction($sql)
    {
        $sql        = str_replace('\t', ' ', $sql);
        $sql        = trim($sql, ' \t\n\r\0\x0B');
        $testArr    = explode(' ', $sql);
        $action     = strtolower($testArr[0]);
        $actionList = ['insert', 'replace', 'delete', 'update', 'select'];
        in_array($action, $actionList) || $action = 'update';
        $action=='replace' && $action='insertReplace';

        return $action;
    }
}
