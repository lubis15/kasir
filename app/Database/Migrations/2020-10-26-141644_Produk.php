<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produk extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_produk' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true
			],
			'id_kategori' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true
			],
			'nama_produk' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'gambar_produk' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'harga' => [
				'type' => 'FLOAT'
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => true
			],
			'deleted_at' => [
				'type' => 'DATETIME',
				'null' => true
			]
		]);
		$this->forge->addPrimaryKey('id_produk', true);
		$this->forge->addForeignKey('id_kategori', 'kategori', 'id_kategori', 'CASCADE', 'CASCADE');
		$this->forge->createTable('produk');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropForeignKey('produk', 'produk_id_kategori_foreign');
		$this->forge->dropTable('produk');
	}
}
