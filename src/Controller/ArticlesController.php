<?php
namespace App\Controller;

use App\Controller;
use Cake\ORM\TableRegistry;

class ArticlesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['tags']);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');

        if (in_array($action, ['add','tags'])) {
            return true;
        }

        $slug = $this->request->getParam('pass.0');
        if (!$slug) {
            return false;
        }

        $article = $this->Articles->findBySlug($slug)->first();

        return $article->user_id == $user['id'];
    }

    public function index()
    {
        $this->loadComponent('Paginator');
        $articles = $this->Paginator->paginate($this->Articles->find('all')->where(['published'=>1]));
        $this->set(compact('articles'));
    }

    public function view($slug = null)
    {
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        $this->set(compact('article'));
    }

    public function add()
    {
        $article = $this->Articles->newEntity();

        if($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            $article->user_id = $this->Auth->user('id');

            if($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article'));
        }
        // get a list of tags
        $tags = $this->Articles->Tags->find('list');

        //set tags to the view context
        $this->set('tags', $tags);

        $this->set('article', $article);
    }

    public function edit($slug)
    {
        $article = $this->Articles
            ->findBySlug($slug)
            ->contain('Tags') //load associated tags
            ->firstOrFail();

        if($this->request->is(['post','put'])) {
            $this->Articles->patchEntity($article, $this->request->getData(),[
                //disabled modification of user_id
                'accessibleFields' => ['user_id' => false]
            ]);
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }
        //get a list of tags
        $tags = $this->Articles->Tags->find('list');

        $this->set('tags', $tags);

        $this->set('article', $article);
    }

    public function delete($slug)
    {
        $this->request->allowMethod(['post','delete']);

        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The {0} article has been deleted.', $article->title));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function tags(...$tags)
    {
        //the 'pass' key is provided by cakephp and contain all
        //the passed URL path segments in the request
//        $tags = $this->request->getParam('pass');

        $articles = $this->Articles->find('tagged',[
            'tags' => $tags
        ]);

        $this->set([
            'articles' => $articles,
            'tags' => $tags
        ]);
    }
}