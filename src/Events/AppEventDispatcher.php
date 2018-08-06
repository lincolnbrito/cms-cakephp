<?php
namespace App\Events;

use Cake\Event\Event;

class AppEventDispatcher
{
    public static function dispatch($name, $subject, $data=null)
    {
        $manager = $subject->getEventManager();
        $event = new Event($name, $subject, $data);

        return $manager->dispatch($event);
    }

    public static function attach($subject, $listenerClass) {
        return $subject->getEventManager()->attach(new $listenerClass);
    }
}