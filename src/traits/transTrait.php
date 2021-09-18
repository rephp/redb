<?php
namespace rephp\redb\traits;
/**
 * Trait transTrait
 * @package rephp\redb\traits
 * @method \rephp\redb\query\cmd getCmd()
 */
trait transTrait
{
    /**
     * 开启事务
     */
    public function startTrans()
    {
        $this->getCmd()->startTrans();
    }

    /**
     * 回滚事务
     */
    public function rollBack()
    {
        $this->getCmd()->rollBack();
    }

    /**
     * 提交事务
     */
    public function commit()
    {
        $this->getCmd()->commit();
    }

}