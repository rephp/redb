<?php

namespace redb\query;

use redb\orm\ormModel;
use redb\query\traits\selectTrait;
use redb\query\traits\insertTrait;
use redb\query\traits\updateTrait;
use redb\query\traits\deleteTrait;
use redb\query\traits\transTrait;
use redb\query\traits\commonTrait;

/**
 * Class cmd
 * @package redb\query
 * @method cmd reConnect()
 */

class cmd
{
    use insertTrait, deleteTrait, updateTrait, selectTrait, transTrait, commonTrait;

    /**
     * @var pdo链接
     */
    protected $pdo;
    protected $host;
    protected $port;
    protected $username;
    protected $password;
    protected $database;
    protected $charset;

    public function __construct($host='127.0.0.1', $port=3389, $username='root', $password='', $database='', $charset='utf8')
    {
        $this->host     = $host;
        $this->port     = $port;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->charset  = $charset;
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
            $sql        = $model->getPresql();
            $bindParams = $model->getBindParams();
            print_r($sql);exit;
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
                    return $this->reConnect()->$action($sql);
                }
            }

        }

        return false;
    }

}