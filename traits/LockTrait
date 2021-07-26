<?php


namespace yii2\traits;


trait LockTrait
{
    protected function locked($key, $expired = 30)
    {
        $key = $this->buildKey($key);
        return !(redis()->set($key, 1, 'nx', 'ex', $expired) ? : false);
    }

    protected function unlock($key)
    {
        $key = $this->buildKey($key);

        redis()->del($key);
    }

    private function buildKey($key)
    {
        return 'tuotuo:hhr:' . $key;
    }
}
