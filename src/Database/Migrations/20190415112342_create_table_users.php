<?php namespace Tatter\Users\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_table_users extends Migration
{
	public function up()
	{
		$fields = [
			'username'       => ['type' => 'VARCHAR', 'constraint' => 63],
			'firstname'      => ['type' => 'VARCHAR', 'constraint' => 63],
			'lastname'       => ['type' => 'VARCHAR', 'constraint' => 63],
			'email'          => ['type' => 'VARCHAR', 'constraint' => 63],
			'password'       => ['type' => 'VARCHAR', 'constraint' => 255],
			'disabled'       => ['type' => 'BOOLEAN', 'default' => 0],
			'deleted'        => ['type' => 'BOOLEAN', 'default' => 0],
			'verified_at'    => ['type' => 'DATETIME', 'null' => true],
			'created_at'     => ['type' => 'DATETIME', 'null' => true],
			'updated_at'     => ['type' => 'DATETIME', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addUniqueKey('email');
		$this->forge->addUniqueKey('username');
		$this->forge->addKey(['deleted', 'id']);
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('users');
	}

	public function down()
	{
		$this->forge->dropTable('users');
		$this->forge->dropTable('groups_users');
	}
}
