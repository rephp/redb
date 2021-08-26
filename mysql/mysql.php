<?php
namespace rephp\database\mysql;

use rephp\database\mysql\traits\commonTrait;
use rephp\database\mysql\traits\selectTrait;
use rephp\database\mysql\console\coreModel;

class mysql
{
    /*
     * model内核
     * @var object
     */
    protected $coreModel;

    use commonTrait;
    use selectTrait;

    /**
     * 获取内核model实例对象
     * @return Model
     */
    public function getCoreModel()
    {
        if(!is_object($this->coreModel)){
            $this->coreModel = new coreModel();
        }
        return $this->coreModel;
    }





}