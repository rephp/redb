<?php
namespace database\mysql;

use database\mysql\traits\commonTrait;
use database\mysql\traits\selectTrait;

class mysql
{
    /*
     * model内核
     * @var object
     */
    protected $coreModel;

    use commonTrait;
    use selectTrait;







}