<?php
namespace demo\model;

class testModel extends model
{
    protected  $db='default';//如果db不填写，默认就是default，此为数据库连接key
    protected  $table='test';//数据表名字，必填
}