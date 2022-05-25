<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'nama' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'level' => [
				'type' => 'ENUM("admin","kasir","owner")',
				'default' => 'kasir'
			],
			'is_aktif' => [
				'type' => 'ENUM("1","0")',
				'default' => '1'
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => true
			]

		]);
		$this->forge->addPrimaryKey('username', true);
		$this->forge->createTable('users');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
