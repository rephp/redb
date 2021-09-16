<?php

namespace demo;


use demo\model\linkCpModel;
use demo\model\testModel;

require 'vendor/autoload.php';
$config = [
    'default' => [
        'host'       => '127.0.0.1',
        'port'       => 3306,
        'username'   => 'root',
        'password'   => '123456',
        'database'   => 'test',
        'charset'    => 'utf8',
        'presistent' => false,
        'debug'      => false,
    ]];

$data = [
    'title' => 'xxx222222',
];
/**********一、插入数据**********/
//0.实例化对象并装在数据
$tester = new testModel($config);
//或者静态对象操作
$tester = testModel::db($config);
//-----------
//1.普通插入
$id     = testModel::db($config)->data($data)->insert();
//或
$id = testModel::db($config)->insert($data);
$id = testModel::db($config)->data($data)->insert();
//当model实现自动加载配置项后可以直接省略参数指定,如:
//$id = testModel::db()->insert($data);
//-----------
//以下只以实例化对象方式演示
//2.忽略插入
$insertCount = testModel::db($config)->insertIgnore($data);
//3.忽略插入
$insertCount = testModel::db($config)->insertReplace($data);
//-----------
//4.批量插入
$insertCount = testModel::db($config)->batchInsert([$data, $data, $data]);
//5.批量忽略插入
$insertCount = testModel::db($config)->batchInsertIgnore([$data, $data, $data]);
//6.批量替换插入
$insertCount = testModel::db($config)->batchInsertReplace([$data, $data, $data]);

/**********二、删除数据**********/
$where       = ['id' => 7];
$deleteCount = testModel::db($config)->where($where)->delete();
//联合删除
$where       = ['T.id' => 7];
$deleteCount = testModel::db($config)->alias('T')->leftJoin(linkCpModel::db($config)->getTable() . ' AS L', 'T.id=L.id')->where(['L.id' => 14])->delete();
/**********三、修改数据**********/

$where        = ['id' => 18];
$updatetCount = testModel::db($config)->where($where)->data($data)->update();
//或者
$updatetCount = testModel::db($config)->where($where)->update($data);
//联合更新
$updatetCount = testModel::db($config)->alias('T')->leftJoin(linkCpModel::db($config)->getTable() . ' AS L', 'T.id=L.id')->where(['L.id' => 14])->update(['T.title' => 'xxx222222']);

/**********四、查取数据**********/
//获取一条
$one = testModel::db($config)->where($where)->one();
//获取所有列表
$list = testModel::db($config)->where($where)->all();
//分页显示第2页数据,支持order by，group by和having
$list = testModel::db($config)->select('title,count(*) AS num')->where($where)->orderBy('id DESC')->groupBy('title')->having('num>1')->limit(20)->page(2)->all();
//统计个数
$count = testModel::db($config)->where($where)->count();
//统计+分页数据
$res = testModel::db($config)->where($where)->page(20)->page(1)->fetch();

//联合查询
$res = testModel::db($config)->alias('T')->leftJoin(linkCpModel::db($config)->getTable() . ' AS L', 'T.id=L.id')->where(['L.title' => 14])->page(20)->page(2)->all();
$res = testModel::db($config)->alias('T')->rightJoin(linkCpModel::db($config)->getTable() . ' AS L', 'T.id=L.id')->where(['L.title' => 14])->page(20)->page(2)->all();
$res = testModel::db($config)->alias('T')->innerJoin(linkCpModel::db($config)->getTable() . ' AS L', 'T.id=L.id')->where(['L.title' => 14])->page(20)->page(2)->all();
//union查询
$list = testModel::db($config)->where($where)->union(linkCpModel::db($config)->where($where))->all();
$list = testModel::db($config)->where($where)->unionAll(linkCpModel::db($config)->where($where))->all();

/**********五、事务**********/
$cmd = testModel::db($config)->getCmd();
$cmd->startTrans();//开启tester对象所在数据库的事务
try{
    $deleteCount  = testModel::db($config)->where($where)->delete();
    $insertCount  = testModel::db($config)->data(['title'=>'xxx', 'id'=>$where['id']])->insertReplace();
    $updatetCount = testModel::db($config)->where($where)->update($data);
    $cmd->commit();    //提交事务
}catch (\Exception $e){
    $cmd->rollBack();  //回滚
}



/**********六、调试**********/
testModel::db($config)->where($where)->all();
//查看执行后的sql
$sql = testModel::db($config)->getSql();
//查看当前sql执行理事
$sqlHistory = testModel::db($config)->getLog();
/**********七、其他**********/
//多库配置+主从
$config = [
    'default' => [
        [
            'host'       => '127.0.0.1',
            'port'       => 3306,
            'username'   => 'root',
            'password'   => '123456',
            'database'   => 'test',
            'charset'    => 'utf8',
            'presistent' => false,
            'type'       => 'master',
        ],
        [
            'host'       => '127.0.0.1',
            'port'       => 3306,
            'username'   => 'root',
            'password'   => '123456',
            'database'   => 'test',
            'charset'    => 'utf8',
            'presistent' => false,
            'type'       => 'slave',
        ],
        [
            'host'       => '127.0.0.1',
            'port'       => 3307,
            'username'   => 'root',
            'password'   => '123456',
            'database'   => 'test',
            'charset'    => 'utf8',
            'presistent' => false,
            'type'       => 'slave',
        ],
        //...
    ],
    'log'     => [
        [
            'host'       => '127.0.0.1',
            'port'       => 3306,
            'username'   => 'root',
            'password'   => '123456',
            'database'   => 'log_db',
            'charset'    => 'utf8',
            'presistent' => false,
            'type'       => 'master',
        ],
        [
            'host'       => '127.0.0.1',
            'port'       => 3306,
            'username'   => 'root',
            'password'   => '123456',
            'database'   => 'log_db',
            'charset'    => 'utf8',
            'presistent' => false,
            'type'       => 'slave',
        ],
        [
            'host'       => '127.0.0.1',
            'port'       => 3307,
            'username'   => 'root',
            'password'   => '123456',
            'database'   => 'test',
            'charset'    => 'utf8',
            'presistent' => false,
            'type'       => 'slave',
        ],
        //...
    ],
];
