<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(Faker $faker)
	{
		for ($i = 0; $i < 10; $i++) {
			$newProject = new Project();

			$newProject->title = $faker->sentence(3); //creo un stringa con 3 parole casuali
			$newProject->description = $faker->text(500); //creo un stringa con 500 caratteri casuali
			$newProject->slug = Str::slug($newProject->title, '-'); //genero lo slug del title
			$newProject->cover_image = $faker->imageUrl(600, 300, 'Projects', 'true'); //creo un link per un immagine placeholder

			$newProject->save();
		}
	}
}
