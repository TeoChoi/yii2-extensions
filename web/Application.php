<?php


namespace yii2\web;


class Application extends \yii\web\Application
{
    public function coreComponents()
    {
        $components = parent::coreComponents();
        $components['request'] = ['class' => Request::class];

        return $components;
    }
}