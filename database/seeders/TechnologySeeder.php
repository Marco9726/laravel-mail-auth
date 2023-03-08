<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Technology;

class TechnologySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(Faker $faker)
	{
		for ($i = 0; $i < 10; $i++) {
			$newTechnology = new Technology();

			$newTechnology->name = $faker->sentence(1); //creo un stringa con parole casuali
			$newTechnology->slug = Technology::generateSlug($newTechnology->name); //genero lo slug del name tramite funzione creata nel Model

			$newTechnology->save();
		}
	}
}
