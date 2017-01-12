<?php
namespace CourseBundle\Notification;

interface NotificationHandler {
    public function handle($order);
}
