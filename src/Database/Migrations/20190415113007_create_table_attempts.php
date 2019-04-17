<?php namespace Tatter\Users\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_table_attempts extends Migration
{
	public function up()
	{
		$fields = [
			'status'         => ['type' => 'VARCHAR', 'constraint' => 31],
			'login'          => ['type' => 'VARCHAR', 'constraint' => 127],
			'user_id'        => ['type' => 'INT'],
			'ip_address'     => ['type' => 'BIGINT'],
			'agent'          => ['type' => 'VARCHAR', 'constraint' => 255],
			'created_at'     => ['type' => 'DATETIME'],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('status');
		$this->forge->addKey('user_id');
		$this->forge->addKey('ip_address');
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('attempts');
	}

	public function down()
	{
		$this->forge->dropTable('attempts');
	}
}
