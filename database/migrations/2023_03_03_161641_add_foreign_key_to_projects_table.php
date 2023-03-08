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
		Schema::table('projects', function (Blueprint $table) {
			//1-CREAZIONE COLONNA 
			$table->unsignedBigInteger('type_id') //<---QUESTO COINCIDE...
				->nullable()
				->after('id');
			//2-CREAZIONE FOREIGN KEY
			$table->foreign('type_id') //<---...CON QUESTO
				->references('id') //NOME DELLA COLONNA...
				->on('types') //...DELLA TABELLA DI RIFERIMENTO
				->onDelete('set null'); //SETTIAMO A NULL LA COLONNA IN CASO CANCELLASSIMO IL TYPE IN QUESTIONE
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('projects', function (Blueprint $table) {
			//1-ELIMINAZIONE DELLA FOREIGN KEY DALLA TABELLA PROJECTS
			$table->dropForeign('projects_type_id_foreign');
			//2-ELIMINAZIONE DELLA COLONNA CHE CONTENA LA FOREIGN
			$table->dropColumn('type_id');
		});
	}
};
