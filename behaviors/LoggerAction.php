<?php


namespace yii2\behaviors;


use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\web\Controller;

class LoggerAction extends Behavior
{
    private $msg = [];

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
            Controller::EVENT_AFTER_ACTION => 'afterAction',
        ];
    }

    /**
     * @param ActionEvent $event
     * @return bool
     */
    public function beforeAction($event)
    {
        $this->msg['input'] = [$_SERVER["REQUEST_URI"], request()->post()];
        return true;
    }

    /**
     * @param ActionEvent $event
     * @return bool
     */
    public function afterAction($event)
    {
        try {
            $this->msg['output'] = $event->result->data;
            $actionId = implode('.', [$event->action->controller->id, $event->action->id]);
            logger("{$actionId}: ", $this->msg);
        } catch (\Exception $exception) {

        }
        return true;
    }
}