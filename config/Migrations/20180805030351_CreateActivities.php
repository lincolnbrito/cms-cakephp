<?php
use Migrations\AbstractMigration;

class CreateActivities extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('activities');
        $table->addColumn('user_id','integer');
        $table->addColumn('foreign_key','integer');
        $table->addColumn('model','string');
        $table->addColumn('type','string');
        $table->create();
    }
}
