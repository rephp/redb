<?php

namespace redb\traits;

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