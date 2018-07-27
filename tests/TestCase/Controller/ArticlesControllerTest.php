<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ArticlesController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;


/**
 * App\Controller\ArticlesController Test Case
 */
class ArticlesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.articles',
        'app.tags',
        'app.users'
    ];

    protected $Articles;

    public function setUp()
    {
        parent::setUp();
        $this->Articles = TableRegistry::get('Articles');
    }

    /** @test */
    public function a_user_can_list_all_articles()
    {
        $this->get('/articles');

        $this->assertResponseOk();
    }

    /** @test */
    public function a_user_can_create_articles()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $data = [
//            'user_id' => 1,
//            'published' => 1,
            'title' => 'Lorem ipsum teste teste',
            'body' => 'Teste asdfsdf sdfs dfsdf',
            'user_id' => 1
        ];
        $this->post(['controller'=>'Articles','action'=>'add'], $data);
        $this->assertPostConditions();

        $query = $this->Articles->find('all');

        $this->assertEquals(1, $query->count());

//        $this->get('/articles');
//        $this->assertResponseContains('New Body');

//
    }

//    /**
//     * Test view method
//     *
//     * @return void
//     */
//    public function testView()
//    {
//        $this->markTestIncomplete('Not implemented yet.');
//    }
//
//    /**
//     * Test add method
//     *
//     * @return void
//     */
//    public function testAdd()
//    {
//        $this->markTestIncomplete('Not implemented yet.');
//    }
//
//    /**
//     * Test edit method
//     *
//     * @return void
//     */
//    public function testEdit()
//    {
//        $this->markTestIncomplete('Not implemented yet.');
//    }
//
//    /**
//     * Test delete method
//     *
//     * @return void
//     */
//    public function testDelete()
//    {
//        $this->markTestIncomplete('Not implemented yet.');
//    }
//
//    /**
//     * Test tags method
//     *
//     * @return void
//     */
//    public function testTags()
//    {
//        $this->markTestIncomplete('Not implemented yet.');
//    }
}
