<?php


namespace yii2\web;


class Request extends \yii\web\Request
{
    public function post($name = null, $defaultValue = null)
    {
        if ($name == null) {
            $params = parent::post($name, $defaultValue);
            $items = [];
            foreach ($params as $key => $value) {
                $items[$key] = trim($value);
            }

            return $items;
        }

        return trim(parent::post($name, $defaultValue));
    }

    public function get($name = null, $defaultValue = null)
    {
        if ($name == null) {
            $params = parent::get($name, $defaultValue);
            $items = [];
            foreach ($params as $key => $value) {
                $items[$key] = trim($value);
            }

            return $items;
        }

        return trim(parent::get($name, $defaultValue));
    }
}