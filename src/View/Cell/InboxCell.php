<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Inbox cell
 */
class InboxCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = ['title'];

    protected $title = 'Article Users';

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize()
    {
        $this->loadModel('Articles');
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        $articles = $this->Articles->find()->count();
        $this->set('articles_count', $articles);
    }

    public function byUser($user)
    {
        $articles = $this->Articles->find()->where(['user_id'=>$user]);
        $this->set(['articles'=>$articles, 'title'=>$this->title]);
    }
}
