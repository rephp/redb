<?php
namespace rephp\database\mysql;

use rephp\database\mysql\traits\commonTrait;
use rephp\database\mysql\traits\selectTrait;
use rephp\database\mysql\console\coreModel;
use rephp\database\mysql\console\cmd;

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
     * 实例化自身对象
     * @return \database\mysql\mysql
     */
    public static function db()
    {
        return new self();
    }

    public function getCmd()
    {
        if(!is_object($this->cmd)){
            $this->cmd = new cmd();
        }
        return $this->cmd;
    }


    /**
     * 获取内核model实例对象
     * @return Model
     */
    final private function getCoreModel()
    {
        if(!is_object($this->coreModel)){
            $this->coreModel = new coreModel();
        }
        return $this->coreModel;
    }


}