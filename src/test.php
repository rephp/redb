<?php
namespace rephp\redb;

require 'vendor/autoload.php';

class test extends redb
{
    protected  $db='master';
    protected  $table='test';

    public function t()
    {
        $model =  test::db()->select('*')->leftJoin('test_table222 as t', 't.id=d.id')->where(['t.id'=>55, 'd.title'=>'aaa'])->groupBy('id')->orderBy('id desc');
        $res = $this->alias('d')->select('d.*')->leftJoin('test_table as t', 't.id=d.id')->where(['t.id'=>55, 'd.title'=>'aaa'])->groupBy('id')->orderBy('id desc')->limit(1)->page(2)->union($model)->setAction('all')->getSql();
var_dump($res);exit;
    }
}

$tester = new test();
$tester->t();