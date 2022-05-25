<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Keranjang extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_keranjang' => [
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => true,
				'auto_increment' => true
			],
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'id_produk' => [
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => true,
			],
			'jumlah' => [
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => true
			],
			'harga' => [
				'type' => 'FLOAT',
				'unsigned' => true
			],
			'total' => [
				'type' => 'FLOAT',
				'unsigned' => true
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => true
			]
		]);
		$this->forge->addPrimaryKey('id_keranjang', true);
		$this->forge->addForeignKey('username', 'users', 'username', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('id_produk', 'produk', 'id_produk', 'CASCADE', 'CASCADE');
		$this->forge->createTable('keranjang');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropForeignKey('keranjang', 'keranjang_id_produk_foreign');
		$this->forge->dropForeignKey('keranjang', 'keranjang_username_foreign');
		$this->forge->dropTable('keranjang');
	}
}
