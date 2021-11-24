<?php

namespace demo\model;

use rephp\redb\redb;

class model extends redb
{
    /**
     * 初始化模型，参数按照model设定的db传参给redb
     */
    public function __construct($configList = [])
    {
        //todo:在用户自己的框架中实现对配置项的读写，故而这里暂时注释
        //empty($configList) && $configList = config('database');
        //获取数据库配置
        $db = $this->getDb();
        if (!isset($configList[$db])) {
            throw new \Exception('2当前模型db配置错误，请检查数据库配置项的key', 1404);
        }
        parent::__construct($configList[$db]);
    }

    /**
     * 静态方法获取动态对象
     * 如果实现__construct方法的自实例化参数加载，即当前demo中注释的第15行：empty($configList) || $configList = config('database');
     * 生效后即可不传递参数而调用本方法
     * 参数按照model设定的db传参实例化redb
     * @param array $configList
     * @return redb
     */
    public static function db($configList = [])
    {
        return new static($configList);
    }
	
	 /**
     * 获取多条数据+条件筛选下的总记录数
     * @return array
     */
    public function fetch()
    {
        $orm   = $this->getOrmModel();
        $list  = $this->all();
        self::doSqlLog();
        $count = $this->setOrmModel($orm)->count();
        return [
            'list'  => $list,
            'count' => $count,
        ];
    }
	
	/**
     * 处理SQL日志
     * @throws \Exception
     */
    public function __destruct()
    {
        self::doSqlLog();
    }

    /**
     * 处理SQL日志
     * @throws \Exception
     */
    protected function doSqlLog()
    {
        //todo: get log filename
	    $logFileName = '';
	    $errorLogFileName = '';
	    //错误日志处理
        $errorLogInfo = $this->getLastErrorLog();
        if(!empty($errorLogInfo)){
            empty($errorLogFileName) || file_put_contents($errorLogFileName, '当前时间:'.date('Y-m-d H:i:s', time()).' | 运行时间:'.$errorLogInfo['time'].' | SQL:'.$errorLogInfo['sql'].' | 错误:'.$errorLogInfo['error']."\n-\n");
			//一次执行，只能产生一条sql，故如果这里报错则不用运行下面正确sql
            return false;
		}
	   
        $sqlInfo = $this->getLastLog();
        //执行日志处理
        if(!empty($sqlInfo)){
            empty($logFileName) || file_put_contents($logFileName, '当前时间:'.date('Y-m-d H:i:s', time()).' | 运行时间:'.$sqlInfo['time'].' | SQL:'.$sqlInfo['sql']."\n-\n");
        }
    }

}