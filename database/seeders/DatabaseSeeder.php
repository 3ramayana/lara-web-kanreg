<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\City;
use App\Models\Departement;
use App\Models\Ministry;
use App\Models\QuestionCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		// \App\Models\User::factory(10)->create();

		// \App\Models\User::factory()->create([
		//     'name' => 'Test User',
		//     'email' => 'test@example.com',
		// ]);

		// City::create([
		// 	'name' => 'Kabupaten Sorong',
		// 	'slug' => 'kabupaten-sorong'
		// ]);

		Ministry::create([
			'name' => 'KEMENKUMHAM',
			'slug' => 'kemenkumham'
		]);

		QuestionCategory::create([
			'name' => 'CAT',
			'slug' => 'cat'
		]);

		Departement::create([
			'name' => 'Bidang Informasi Kepegawaian',
			'slug' => Str::slug('Bidang Informasi Kepegawaian'),
		]);

		$data = User::create([
			'name' => 'Admin',
			'departement_id' => 1,
			'email' => 'admin@admin.test',
			'nip'	=> '199806162022031006',
			'email_verified_at' => now(),
			'password' => bcrypt('12345')
		]);

		$penulis = User::create([
			'name' => 'Admin Arsip',
			'departement_id' => 1,
			'email' => 'penulis@penulis.test',
			'nip'	=> '000000',
			'email_verified_at' => now(),
			'password' => bcrypt('12345')
		]);

		$data->assignRole('admin');
		$penulis->assignRole('penulis');

		// Category::create([
		// 	'name' => 'Berita Kepegawaian',
		// 	'slug' => 'berita-kepegawaian'
		// ]);

		// Category::create([
		// 	'name' => 'Artikel Kepegawaian',
		// 	'slug' => 'artike-kepegawaian'
		// ]);

		// Category::create([
		// 	'name' => 'Pengumuman',
		// 	'slug' => 'pengumuman'
		// ]);

		// Category::create([
		// 	'name' => 'Dokumen',
		// 	'slug' => 'dokumen'
		// ]);

		// Category::create([
		// 	'name' => 'Pengumuman',
		// 	'slug' => 'pengumuman'
		// ]);
	}
}
