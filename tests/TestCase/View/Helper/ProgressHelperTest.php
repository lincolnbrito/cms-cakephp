<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\ProgressHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\ProgressHelper Test Case
 */
class ProgressHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\ProgressHelper
     */
    public $ProgressHelper;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->ProgressHelper = new ProgressHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProgressHelper);

        parent::tearDown();
    }

    /** @test */
    public function verify_width_of_bar()
    {
        $result = $this->ProgressHelper->bar(90);
        $this->assertContains('width: 90%', $result);
        $this->assertContains('progress-bar', $result);

        $result = $this->ProgressHelper->bar(33);
        $this->assertContains('width: 33%', $result);
    }
}
