<?php namespace Tatter\Users\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_table_groups extends Migration
{
	public function up()
	{
		$fields = [
			'name'           => ['type' => 'VARCHAR', 'constraint' => 63],
			'description'    => ['type' => 'VARCHAR', 'constraint' => 255],
			'deleted'        => ['type' => 'BOOLEAN', 'default' => 0],
			'created_at'     => ['type' => 'DATETIME', 'null' => true],
			'updated_at'     => ['type' => 'DATETIME', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('name');
		$this->forge->addKey(['deleted', 'id']);
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('groups');
		
		// add users pivot table
		$fields = [
			'group_id'       => ['type' => 'INT', 'unsigned' => true],
			'user_id'        => ['type' => 'INT', 'unsigned' => true],
			'created_at'     => ['type' => 'DATETIME', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addUniqueKey(['group_id', 'user_id']);
		$this->forge->addUniqueKey(['user_id', 'group_id']);
		
		$this->forge->createTable('groups_users');
	}

	public function down()
	{
		$this->forge->dropTable('groups');
		$this->forge->dropTable('groups_users');
	}
}
