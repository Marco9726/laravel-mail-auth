<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Technology extends Model
{
	protected $fillable = ['name', 'slug'];
	use HasFactory;
	//funzione per generare lo slug
	public static function generateSlug($name)
	{
		return Str::slug($name, '-');
	}
	//MANY TO MANY
	public function projects()
	{
		return $this->belongsToMany(Project::class);
	}
}
