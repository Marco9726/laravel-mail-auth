<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
//Importiamo il Model della tabella in relazione
// use App\Models\Project;

class Type extends Model
{
	protected $fillable = ['name', 'slug'];
	use HasFactory;
	//funzione per generare lo slug
	public static function generateSlug($name)
	{
		return Str::slug($name, '-');
	}
	//ONE TO MANY
	//Nel Model principale inseriamo una funzione con un nome che identifichi la relazione con l’altra tabella.
	public function projects()
	{
		//essendo una relazione one(type) to many(projects) utilizziamo il metodo hasMany()
		return $this->hasMany(Project::class);
	}
}
