<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\ActivityRecordBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\ActivityRecordBehavior Test Case
 */
class ActivityRecordBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Behavior\ActivityRecordBehavior
     */
    public $ActivityRecord;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->ActivityRecord = new ActivityRecordBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ActivityRecord);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
