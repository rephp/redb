<?php

namespace rephp\redb\query;

use rephp\redb\query\traits\selectTrait;
use rephp\redb\query\traits\insertTrait;
use rephp\redb\query\traits\updateTrait;
use rephp\redb\query\traits\deleteTrait;
use rephp\redb\query\traits\transTrait;
use rephp\redb\query\traits\commonTrait;

/**
 * Class cmd
 * @package rephp\redb\query
 * @method cmd reConnect()
 */
class cmd
{
    use insertTrait, deleteTrait, updateTrait, selectTrait, transTrait, commonTrait;

    /**
     * @var pdo链接
     */
    protected $pdo;
    protected $config = [];
    protected $configType = 'master';
    protected $debug = false;

    public function __construct(array $config)
    {
        $this->config       = $config;
    }

    /**
     * @param string $preSql
     * @param array  $params
     * @return \PDOStatement
     */
    public function execute($preSql, $params = [])
    {
        $startTime = microtime(true);
        try {
            //创建pdo预处理对象
            $stmt = $this->getPdo()->prepare($preSql);
            //绑定参数到预处理对象
            $index = 1;
            foreach ($params as $fileld => $value) {
                $stmt->bindValue($index, $value);
                $index++;
            }
            //执行命令
            if($this->debug){
                echo vsprintf(str_replace('?', '\'%s\'', $preSql), $params);
            }
            echo vsprintf(str_replace('?', '\'%s\'', $preSql), $params);
            $stmt->execute();
            log::setLog(vsprintf(str_replace('?', '\'%s\'', $preSql), $params), round(microtime(true) - $startTime, 6));
            return $stmt;

        } catch (\Exception $e) {
            //其他情况记录mysql错误日志
            $extErrorInfo = [
                'code' => $e->getCode(),
                'msg'  => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
            log::setErrorLog(vsprintf(str_replace('?', '\'%s\'', $preSql), $params), round(microtime(true) - $startTime, 6), $extErrorInfo);
        }

        return false;
    }

    public function queryRaw($sql)
    {
        //分析sql
        $action = $this->getRawAction($sql);
        if (!method_exists($this, $action)) {
            return false;
        }
        //2.执行并返回结果
        try {
            return $this->$action($sql, []);
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
                return $this->reConnect()->$action($sql, []);
            }

            throw $e;
        }

        return false;
    }

}