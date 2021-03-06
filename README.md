## 安装Redb

# Installation

```
composer require rephp/redb
```

## Quick start
```
$config = [
    'default' => [
        'host'       => '127.0.0.1',
        'port'       => 3306,
        'username'   => 'root',
        'password'   => '123456',
        'database'   => 'test',
        'charset'    => 'utf8',
        'presistent' => false,
    ]];

$data = [
    'title' => 'xxx222222',
];
/**********一、插入数据**********/
//1.实例化对象并装在数据
$tester = new testModel($config);
//或者静态对象操作
$tester = testModel::db($config);
$id     = $tester->data($data)->insert();
//或
$id = $tester->insert($data);
//-----------
//以下只以实例化对象方式演示
//2.忽略插入
$insertCount = $tester->insertIgnore($data);
//3.忽略插入
$insertCount = $tester->insertReplace($data);
//4.批量插入
$insertCount = $tester->batchInsert([$data, $data, $data]);
//5.批量忽略插入
$insertCount = $tester->batchInsertIgnore([$data, $data, $data]);
//6.批量替换插入
$insertCount = $tester->batchInsertReplace([$data, $data, $data]);

/**********二、删除数据**********/
$where       = ['id' => 7];
$deleteCount = $tester->where($where)->delete();
//联合删除
$deleteCount = $tester->alias('T')->leftJoin(linkCpModel::getTableName() . ' AS L', 'T.id=L.id')->where(['L.id' => 14])->delete();
/**********三、修改数据**********/
$where        = ['id' => 7];
$updatetCount = $tester->where($where)->data($data)->update();
//或者
$updatetCount = $tester->where($where)->update($data);
//联合更新
$updatetCount = $tester->alias('T')->leftJoin(linkCpModel::getTableName() . ' AS L', 'T.id=L.id')->where(['L.id' => 14])->update(['T.title' => 'xxx222222']);
/**********四、查取数据**********/
//获取一条
$one = $tester->where($where)->one();
//获取所有列表
$list = $tester->where($where)->all();
//分页显示第2页数据,支持order by，group by和having
$list = $tester->select('title,count(*) AS num')->where($where)->orderBy('id DESC')->groupBy('title')->having('num>1')->limit(20)->page(2)->all();
//统计个数
$count = $tester->where($where)->count();
//统计+分页数据
$res = $tester->where($where)->page(20)->page(2)->fetch();
//联合查询
$res = $tester->alias('T')->leftJoin(linkCpModel::getTableName() . ' AS L', 'T.id=L.id')->where(['L.title' => 14])->page(20)->page(2)->all();
$res = $tester->alias('T')->rightJoin(linkCpModel::getTableName() . ' AS L', 'T.id=L.id')->where(['L.title' => 14])->page(20)->page(2)->all();
$res = $tester->alias('T')->innerJoin(linkCpModel::getTableName() . ' AS L', 'T.id=L.id')->where(['L.title' => 14])->page(20)->page(2)->all();
//union查询
$list = $tester->where($where)->union(linkCpModel::db()->where($where))->all();
$list = $tester->where($where)->unionAll(linkCpModel::db()->where($where))->all();

/**********五、事务**********/
$cmd = $tester->getCmd();
$cmd->startTrans();//开启tester对象所在数据库的事务
$cmd->commit();    //提交事务
$cmd->rollBack();  //回滚

/**********六、调试**********/
$tester->where($where)->update;
//查看执行后的sql
$sql = $tester->getSql();
//查看当前sql执行理事
$sqlHistory = $tester->getLog();

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
    ],
];
```