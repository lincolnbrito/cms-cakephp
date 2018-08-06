<?php
namespace App\Events;

use Cake\Core\Configure;
use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\ORM\Query;

class TesteListener implements EventListenerInterface
{


    public function implementedEvents()
    {
        return array(
            'Model.initialize' => 'initializeEvent',
        );
    }
    public function initializeEvent($event)
    {

        if($event->getSubject()->getAlias()=="Activities"){
            $event->getSubject()->belongsTo('Articles', [
                'className' => 'Articles',
                'foreignKey' => 'foreign_key',
                'bindingKey' => 'id',
                'coditions' => ['Activities.model'=>'Articles']
            ]);

        }

        Configure::write('evento',$event->getSubject()->getAlias());
//        dd($event->getSubject());
        // do something here
        return $event;
    }
}