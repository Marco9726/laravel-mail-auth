<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Type\StoreTypeRequest;
use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$types = Type::all();

		$typesIcons = [
			'Html' => 'html5',
			'Css' => 'css3-alt',
			'JavaScript' => 'js',
			'Vue' => 'vuejs',
			'PHP' => 'php',
			'Laravel' => 'laravel'
		];

		return view('admin.types.index', compact('types', 'typesIcons'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$types = Type::all();
		return view('admin.types.create', compact('types'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreTypeRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreTypeRequest $request)
	{
		$form_data = $request->validated();

		$slug = Type::generateSlug($request->name); //richiamo la funzione creata nel model per generare lo slug
		//Aggiungo una coppia chiave = valore all'array form_data
		$form_data['slug'] = $slug;

		$newType = new Type();
		$newType->fill($form_data);

		$newType->save();
		//QUESTE TRE OPERAZIONE CORRISPONDONO A:
		// $newType = Type::create($form_data); 
		return redirect()->route('admin.types.index')->with('message', 'Linguaggio creato correttamente'); //passo alla view anche la variabile message
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Type  $type
	 * @return \Illuminate\Http\Response
	 */
	public function show(Type $type)
	{
		$typesIcons = [
			'Html' => 'html5',
			'Css' => 'css3-alt',
			'JavaScript' => 'js',
			'Vue' => 'vuejs',
			'PHP' => 'php',
			'Laravel' => 'laravel'
		];

		return view('admin.types.show', compact('type', 'typesIcons'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Type  $type
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Type $type)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Type  $type
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Type $type)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Type  $type
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Type $type)
	{
		$type->delete();

		return redirect()->route('admin.types.index')->with('message', 'Linguaggio ' . $type->title . ' è stato eliminato');
	}
}
