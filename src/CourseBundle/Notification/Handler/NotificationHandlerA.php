<?php
namespace CourseBundle\Notification\Handler;

use CourseBundle\Notification\NotificationHandler;

class NotificationHandlerA implements NotificationHandler {
    public function handle($order) {
        file_put_contents('/var/logs/handlerA.log', date('r').": handlerA('.$order.') ", FILE_APPEND);
    }
}
