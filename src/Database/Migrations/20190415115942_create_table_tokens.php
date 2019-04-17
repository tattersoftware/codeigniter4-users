<?php namespace Tatter\Users\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_table_tokens extends Migration
{
	public function up()
	{
		$fields = [
			'type'           => ['type' => 'VARCHAR', 'constraint' => 15],
			'content'        => ['type' => 'VARCHAR', 'constraint' => 255],
			'user_id'        => ['type' => 'INT'],
			'ip_address'     => ['type' => 'BIGINT'],
			'agent'          => ['type' => 'VARCHAR', 'constraint' => 255],
			'created_at'     => ['type' => 'DATETIME'],
			'updated_at'     => ['type' => 'DATETIME'],
			'expired_at'     => ['type' => 'DATETIME', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey(['user_id', 'type']);
		$this->forge->addKey(['type', 'content']);
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('tokens');
	}

	public function down()
	{
		$this->forge->dropTable('tokens');
	}
}
