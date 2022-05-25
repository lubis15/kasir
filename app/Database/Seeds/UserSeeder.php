<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserSeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'username' => 'admin',
				'password' => password_hash('12345678', PASSWORD_BCRYPT),
				'nama' => 'Administrator',
				'level' => ['admin'],
				'is_aktif' => ['1'],
				'created_at' => Time::now()
			],
			[
				'username' => 'budi',
				'password' => password_hash('12345678', PASSWORD_BCRYPT),
				'nama' => 'Budi Susanto',
				'level' => ['kasir'],
				'is_aktif' => ['1'],
				'created_at' => Time::now()
			],
			[
				'username' => 'joni',
				'password' => password_hash('12345678', PASSWORD_BCRYPT),
				'nama' => 'Joni Prakoso',
				'level' => ['owner'],
				'is_aktif' => ['1'],
				'created_at' => Time::now()
			]
		];

		$this->db->table('users')->insertBatch($data);
	}
}
