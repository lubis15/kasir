<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_transaksi' => [
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => true,
				'auto_increment' => true
			],
			'no_transaksi' => [
				'type' => 'VARCHAR',
				'constraint' => '12',
				'unique' => true
			],
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'nama_pelanggan' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'no_meja' => [
				'type' => 'INT',
				'constraint' => '11'
			],
			'catatan' => [
				'type' => 'TEXT'
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => TRUE
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => TRUE
			]

		]);

		$this->forge->addPrimaryKey('id_transaksi', true);
		$this->forge->addForeignKey('username', 'users', 'username', 'CASCADE', 'CASCADE');
		$this->forge->createTable('transaksi');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropForeignKey('transaksi', 'transaksi_username_foreign');
		$this->forge->dropTable('transaksi');
	}
}
