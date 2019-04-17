<?php namespace Tatter\Users\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_table_logins extends Migration
{
	public function up()
	{
		$fields = [
			'user_id'          => ['type' => 'INT'],
			'ip_address'       => ['type' => 'BIGINT'],
			'agent'            => ['type' => 'VARCHAR', 'constraint' => 255],
			'depth'            => ['type' => 'INT', 'unsigned' => true],
			'impersonated_by'  => ['type' => 'INT', 'null' => true],
			'created_at'       => ['type' => 'DATETIME'],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('user_id');
		$this->forge->addKey('ip_address');
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('logins');
	}

	public function down()
	{
		$this->forge->dropTable('logins');
	}
}
