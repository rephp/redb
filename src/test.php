<?php
namespace redb;

require 'vendor/autoload.php';

class test extends redb
{
    protected  $db='master';
    protected  $table='test';

    public function t()
    {
        $res = $this->data(['id'=>'1', 'title'=>'test'])->where(['id'=>55])->update();
var_dump($res);exit;
    }
}

$tester = new test();
$tester->t();