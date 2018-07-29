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
        //'app.tags',
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
    public function an_unautheticated_user_can_not_create_articles()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $data = [
            'title' => 'The new article',
            'body' => 'The amazing body',
            'user_id' => 1
        ];
        $this->post(['controller'=>'Articles','action'=>'add'], $data);
        $this->assertRedirect(['controller'=>'Users', 'action'=>'login']);
    }

    /** @test */
    public function an_authenticated_user_can_create_an_article()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1
                ]
            ]
        ]);

        $data = [
            'title' => 'The new article',
            'body' => 'The amazing body',
            'user_id' => 1
        ];

        $this->post(['controller'=>'Articles','action'=>'add'], $data);
        $this->assertRedirect(['controller'=>'Articles', 'action'=>'index']);

        $this->get('/articles');
        $this->assertResponseContains('The new article');
    }

    /** @test */
    public function show_only_published_articles()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data = [
            [
                'title' => 'First article',
                'body' => 'First article body',
                'user_id' => 1,
                'published' => 1
            ],
            [
                'title' => 'Second article',
                'body' => 'Second article body',
                'user_id' => 1,
                'published' => 0
            ],
            [
                'title' => 'Third article',
                'body' => 'Third article body',
                'user_id' => 1,
                'published' => 0
            ],
        ];

        $entities = $this->Articles->newEntities($data);
        $save = $this->Articles->saveMany($entities);

        $this->get('/articles');
        $this->assertResponseContains('First article');
        $this->assertResponseNotContains('Third article');
        $this->assertResponseNotContains('Second article');
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
