<?php
namespace rephp\redb;

require 'vendor/autoload.php';

class test extends redb
{
    protected  $db='default';
    protected  $table='test';

    public function t()
    {

        $res = self::db();
//        $model =  test::db()->select('*')->leftJoin('test_table222 as t', 't.id=d.id')->where(['t.id'=>55, 'd.title'=>'aaa'])->groupBy('id')->orderBy('id desc');
//        $res = $this->alias('d')->select('d.*')->leftJoin('test_table as t', 't.id=d.id')->where(['t.id'=>55, 'd.title'=>'aaa'])->groupBy('id')->orderBy('id desc')->limit(1)->page(2)->union($model)->setAction('all')->getSql();

    }
}
$config = [
    'default'=>[
    'host' => '127.0.0.1',
    'port'       => 3306,
    'username'   => 'root',
    'password'   => '123456',
    'database'   => 'test',
    'charset'    => 'utf8',
    'presistent' => false,
]];
$tester = new test($config);
$data = [
    'ttile'=>'xxxxx',
];
$res = $tester->insert($data);
var_dump($res);exit;