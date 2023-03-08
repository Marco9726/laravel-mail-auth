<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_technology', function (Blueprint $table) {
			$table->id();
			//1-CREAZIONE COLONNA PER IL PROJECT
			$table->unsignedBigInteger('project_id'); //<---QUESTO COINCIDE...
			//2-CREAZIONE FOREIGN KEY
			$table->foreign('project_id') //<---...CON QUESTO
				->references('id') //NOME DELLA COLONNA...
				->on('projects') //...DELLA TABELLA DI RIFERIMENTO
				->cascadeOnDelete();


			//1-CREAZIONE COLONNA PER LA TECHNOLOGY
			$table->unsignedBigInteger('technology_id'); //<---QUESTO COINCIDE...
			//2-CREAZIONE FOREIGN KEY
			$table->foreign('technology_id') //<---...CON QUESTO
				->references('id') //NOME DELLA COLONNA...
				->on('technologies') //...DELLA TABELLA DI RIFERIMENTO
				->cascadeOnDelete();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('project_technology');
	}
};
