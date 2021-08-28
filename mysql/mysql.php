<?php
namespace redb\mysql;

use redb\mysql\traits\commonTrait;
use redb\mysql\traits\selectTrait;
use redb\mysql\console\coreModel;
use redb\mysql\console\cmd;
use redb\mysql\traits\insertTrait;
use redb\mysql\traits\deleteTrait;
use redb\mysql\traits\updateTrait;

class mysql
{
    /*
     * model内核
     * @var object
     */
    protected $coreModel;

    use commonTrait;
    use insertTrait;
    use deleteTrait;
    use updateTrait;
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
     * @return coreModel
     */
    final private function getCoreModel()
    {
        if(!is_object($this->coreModel)){
            $this->coreModel = new coreModel();
        }
        return $this->coreModel;
    }


}