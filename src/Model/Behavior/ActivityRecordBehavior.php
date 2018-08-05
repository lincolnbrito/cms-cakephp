<?php
namespace App\Model\Behavior;

use \ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

/**
 * ActivityRecord behavior
 */
class ActivityRecordBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function initialize(array $config)
    {
        $this->_table->hasMany('Activities', [
            'className' => 'Activities',
            'foreignKey' => 'foreign_key',
            'conditions' => ['Activities.model' => $this->getTable()->getAlias()]
        ]);
        $this->_table->Activities->belongsTo( $this->getTable()->getAlias(), [
            'className' =>  $this->getTable()->getAlias(),
            'foreignKey' => 'foreign_key',
            'conditions' => ['Activities.model' => $this->getTable()->getAlias()]
        ]);
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->saveActivity($entity, $event);
    }

    public function saveActivity($entity, $event){
//        dd($event);
        $activitiesTable = TableRegistry::getTableLocator()->get('Activities');
        $activity = $activitiesTable->newEntity(['model'=>$this->_table->getAlias(),'foreign_key'=>$entity->id,'user_id'=>'']);
        $activitiesTable->saveOrFail($activity);
    }
}
