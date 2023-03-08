<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
//Importiamo il Model della tabella in relazione
// use App\Models\Type;

class Project extends Model
{
	//variabile fillable
	protected $fillable = ['title', 'description', 'slug', 'type_id', 'technology_id', 'cover_image'];
	use HasFactory;
	//funzione per generare lo slug
	public static function generateSlug($title)
	{
		return Str::slug($title, '-');
	}

	// ONE TO MANY 
	//Nel nostro caso, inseriamo nel Model secondario Project il metodo type() che rappresenta la relazione di dipendenza verso il Model Type principale.
	public function type()
	{
		//nel Model secondario mappiamo la relazione inversa usando il metodo belongsTo().
		return $this->belongsTo(Type::class);
	}

	//MANY TO MANY
	public function technologies()
	{
		return $this->belongsToMany(Technology::class);
	}
}
