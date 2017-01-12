<?php
namespace CourseBundle\Notification;

class OrderNotification {
    private $handlers = [];
    
    
    public function addHandler(NotificationHandler $handler) {
        $this->handlers[] = $handler;
    }
    
    public function send() {
        $id = 0;
        foreach ($this->handlers as $handler) {
            $handler->handle($id++);
        }
    }
}
