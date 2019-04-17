<?php namespace Tatter\Users\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_table_resets extends Migration
{
	public function up()
	{
		$fields = [
			'user_id'        => ['type' => 'INT'],
			'token_id'       => ['type' => 'INT'],
			'ip_address'     => ['type' => 'BIGINT'],
			'agent'          => ['type' => 'VARCHAR', 'constraint' => 255],
			'created_at'     => ['type' => 'DATETIME'],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('user_id');
		$this->forge->addKey('token_id');
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('resets');
	}

	public function down()
	{
		$this->forge->dropTable('resets');
	}
}
