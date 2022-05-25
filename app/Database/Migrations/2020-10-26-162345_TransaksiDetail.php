<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransaksiDetail extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_transaksi_detail' => [
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => true,
				'auto_increment' => true
			],
			'id_transaksi' => [
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => true
			],
			'id_produk' => [
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => true
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

		$this->forge->addPrimaryKey('id_transaksi_detail', true);
		$this->forge->addForeignKey('id_transaksi', 'transaksi', 'id_transaksi', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('id_produk', 'produk', 'id_produk', 'CASCADE', 'CASCADE');
		$this->forge->createTable('transaksi_detail');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropForeignKey('transaksi_detail', 'transaksi_detail_id_produk_foreign');
		$this->forge->dropForeignKey('transaksi_detail', 'transaksi_detail_id_transaksi_foreign');
		$this->forge->dropTable('transaksi_detail');
	}
}
