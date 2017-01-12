<?php
namespace CourseBundle\Notification\Handler;

use CourseBundle\Notification\NotificationHandler;

class NotificationHandlerB implements NotificationHandler {
    public function handle($order) {
        file_put_contents('/var/logs/handlerA.log', date('r').": handlerB('.$order.')  ", FILE_APPEND);
    }
}
