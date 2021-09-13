<?php
namespace demo\model;

class linkCpModel extends model
{
    protected  $db='default';//如果db不填写，默认就是default，此为数据库连接key
    protected  $table='link_cp';//数据表名字，必填
}