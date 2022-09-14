<?php

namespace rephp\redb\traits;

/**
 * Trait deleteTrait
 * @package rephp\redb\traits
 * @method \rephp\redb\redb setAction()
 */
trait deleteTrait
{
    /**
     * 删除
     * @return mixed
     */
    public function delete()
    {
        return $this->setAction('delete')->run();
    }
}
