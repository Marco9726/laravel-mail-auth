<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;

class ProjectController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$projects = Project::all();
		return view('admin.projects.index', compact('projects'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$types = Type::all();
		$technologies = Technology::all();
		return view('admin.projects.create', compact('types', 'technologies'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreProjectRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreProjectRequest $request)
	{
		// Recupero i dati validati dalla richiesta
		$form_data = $request->validated();

		$slug = Project::generateSlug($request->title); //richiamo la funzione creata nel model per generare lo slug
		//Aggiungo una coppia chiave = valore all'array form_data
		$form_data['slug'] = $slug;


		//controlliamo prima del fill se è presente l'indice per salvarci il path da salvare una volta eseguito l'upload
		if ($request->has('cover_image')) {
			$path = Storage::disk('public')->put('project_images', $request->cover_image);

			$form_data['cover_image'] = $path;
		}

		// Creo e salvo un nuovo progetto nel db utilizzando i datipassati dal form
		$newProject = Project::create($form_data);

		if ($request->has('technologies')) {
			$newProject->technologies()->attach($request->technologies);
		}

		return redirect()->route('admin.projects.index')->with('message', 'Progetto creato correttamente'); //passo alla view anche la variabile message
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Project  $project
	 * @return \Illuminate\Http\Response
	 */
	public function show(Project $project)
	{
		return view('admin.projects.show', compact('project'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Project  $project
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Project $project)
	{
		$types = Type::all();
		$technologies = Technology::all();

		return view('admin.projects.edit', compact('project', 'types', 'technologies'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateProjectRequest  $request
	 * @param  \App\Models\Project  $project
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateProjectRequest $request, Project $project)
	{
		$form_data = $request->validated();
		//richiamo la funzione per generare lo slug creata nel Model, passando il title come parametro
		$slug = Project::generateSlug($request->title, '-');

		$form_data['slug'] = $slug;

		$project->update($form_data);

		if ($request->has('technologies')) {
			//tramite la funzione sync(), passiamo un array di id che vengono confontranti con quelli nel db: elimina dal db quelli assenti nell'array, lascia quelli presenti e ne aggiunge quelli non presenti nel db
			$project->technologies()->sync($request->technologies);
		}

		return redirect()->route('admin.projects.index')->with('message', 'Progetto ' . $project->title . ' è stato modificato correttamente');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Project  $project
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Project $project)
	{
		//!-1):CANCELLARE PRIMA I RECORD NELLA TABELLA PIVOT (funzione già svolta dai metodi cascateOnDelete() dichiaricati nella migrations della tabella pivot)
		// $project->technologies->sync([]);

		$project->delete();

		return redirect()->route('admin.projects.index')->with('message', 'Progetto ' . $project->title . ' è stato eliminato');
	}
}
