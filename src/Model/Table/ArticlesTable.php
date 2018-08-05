<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class ArticlesTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Timestamp');
        $this->addBehavior('ActivityRecord');
        $this->belongsToMany('Tags');
    }

    public function beforeSave($event, $entity, $options)
    {
        if ($entity->tag_string) {
            $entity->tags = $this->_buildTags($entity->tag_string);
        }

        if($entity->isNew() && !$entity->slug) {
            $sluggedTitle = Text::slug($entity->title);
            $entity->slug = substr($sluggedTitle, 0,191);
        }
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('title')
            ->minLength('title',10)
            ->maxLength('title', 50)

            ->notEmpty('body')
            ->minLength('body', 10);

        return $validator;
    }

    public function findTagged(Query $query, array $options)
    {
        $columns = [
            'Articles.id','Articles.user_id', 'Articles.title',
            'Articles.body', 'Articles.published', 'Articles.created',
            'Articles.slug'
        ];

        $query = $query
            ->select($columns)
            ->distinct($columns);

        if (empty($options['tags'])) {
            $query->leftJoinWith('Tags')
                ->where(['Tags.title IS' => null]);
        } else {
            $query->innerJoinWith('Tags')
                ->where(['Tags.title IN' => $options['tags']]);
        }

        return $query->group(['Articles.id']);
    }

    public function findPublished(Query $query, $options)
    {
        $query->where([
            $this->getAlias().'.published' => 1
        ]);

        return $query;
    }


    protected function _buildTags($tagString)
    {
        $newTags = array_map('trim', explode(',', $tagString));

        $newTags = array_filter($newTags);

        $newTags = array_unique($newTags);

        $out = [];

        $query = $this->Tags->find()
            ->where(['Tags.title IN' => $newTags]);

        //remove existing tags from the list of new tags
        foreach($query->extract('title') as $existing) {
            $index = array_search($existing, $newTags);
            if( $index !== false ) {
                unset($newTags[$index]);
            }
        }

        //add existing tags
        foreach ($query as $tag) {
            $out[] = $tag;
        }
        //add new tags
        foreach ($newTags as $tag) {
            $out[] = $this->Tags->newEntity(['title'=>$tag]);
        }

        return $out;
    }
}