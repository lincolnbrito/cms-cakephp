<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ArticlesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ArticlesTable Test Case
 */
class ArticlesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ArticlesTable
     */
    public $ArticlesTable;

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

//    public $autoFixtures = false;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Articles') ? [] : ['className' => ArticlesTable::class];
        $this->ArticlesTable = TableRegistry::getTableLocator()->get('Articles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ArticlesTable);

        parent::tearDown();
    }

//    /**
//     * Test initialize method
//     *
//     * @return void
//     */
//    public function testInitialize()
//    {
//        //$this->markTestIncomplete('Not implemented yet.');
//    }
//
//    /**
//     * Test beforeSave method
//     *
//     * @return void
//     */
//    public function testBeforeSave()
//    {
//        //$this->markTestIncomplete('Not implemented yet.');
//    }
//

    /** @test */
    public function validation_default()
    {
        $article = $this->ArticlesTable->newEntity(['title' => 'Short', 'body' => 'A long long time ago']);
        $this->assertNotEmpty($article->getError('title'));

        $article = $this->ArticlesTable->newEntity(['title' => 'A logn long title ago', 'body' => 'short']);
        $this->assertNotEmpty($article->getError('body'));
    }
//
//    /**
//     * Test findTagged method
//     *
//     * @return void
//     */
//    public function testFindTagged()
//    {
//        //$this->markTestIncomplete('Not implemented yet.');
//    }

    /** @test */
    public function find_published()
    {
//        $this->loadFixtures('Users', 'Articles', 'Tags');

        $query = $this->ArticlesTable->find('published', ['fields' => ['id', 'title']]);
        $this->assertInstanceOf('Cake\ORM\Query', $query);

        $article = $this->ArticlesTable->newEntity();
        $article->user_id = 1;
        $this->ArticlesTable->patchEntity($article, ['title' => 'First Article', 'published' => 1]);
        $this->ArticlesTable->save($article);

        $result = $query->enableHydration(false)->toArray();
        $expected = [
            ['id' => 1, 'title' => 'First Article']
        ];

        $this->assertEquals($expected, $result);
    }

}
