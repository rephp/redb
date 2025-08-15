<?php

namespace rephp\redb\query\traits;

use rephp\redb\query\log;

/**
 * Trait transTrait
 * @package rephp\redb\query\traits
 * @method \PDO getPdo()
 * @method commonTrait setConfigType($type)
 */
trait transTrait
{
    public function startTrans()
    {
        $startTime = microtime(true);
        try{
            $this->setConfigType($type = 'master')->getPdo()->beginTransaction();
        }catch (\Exception $e){
            $extErrorInfo = [
                'code' => $e->getCode(),
                'msg'  => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
            if ($this->debug) {
                print_r($extErrorInfo);
            }
            log::setErrorLog('beginTransaction', round(microtime(true) - $startTime, 6), $extErrorInfo);
        }

        return $this;
    }

    public function rollBack()
    {
        $startTime = microtime(true);
        try{
            $this->setConfigType($type = 'master')->getPdo()->rollBack();
        }catch (\Exception $e){
            $extErrorInfo = [
                'code' => $e->getCode(),
                'msg'  => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
            if ($this->debug) {
                print_r($extErrorInfo);
            }
            log::setErrorLog('beginTransaction', round(microtime(true) - $startTime, 6), $extErrorInfo);
        }

        return $this;
    }

    public function commit()
    {
        $startTime = microtime(true);
        try{
            $this->setConfigType($type = 'master')->getPdo()->commit();
        }catch (\Exception $e){
            $extErrorInfo = [
                'code' => $e->getCode(),
                'msg'  => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
            if ($this->debug) {
                print_r($extErrorInfo);
            }
            log::setErrorLog('beginTransaction', round(microtime(true) - $startTime, 6), $extErrorInfo);
        }

        return $this;
    }

}
