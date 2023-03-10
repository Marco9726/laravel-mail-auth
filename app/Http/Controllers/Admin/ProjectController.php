<?php

namespace App\Http\Controllers\Admin;
// facades
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
// controller
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
// models 
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use App\Models\Lead;
// mail
use App\Mail\NewContact;

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
		if ($request->hasFile('cover_image')) {
			// inseriamo l'immagine nella cartella 'project_images', nella cartella public di storage
			$path = Storage::disk('public')->put('project_images', $request->cover_image);

			$form_data['cover_image'] = $path;
		}

		// Creo e salvo un nuovo progetto nel db utilizzando i datipassati dal form
		$newProject = Project::create($form_data);

		if ($request->has('technologies')) {
			$newProject->technologies()->attach($request->technologies);
		}

		$new_lead = new Lead();
		$new_lead->title = $form_data['title'];
		$new_lead->slug = $form_data['slug'];
		$new_lead->description = $form_data['description'];
		$new_lead->save();

		Mail::to('info@boolpress.com')->send(new NewContact($new_lead));

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
		// Recupero i dati validati dalla richiesta
		$form_data = $request->validated();
		//richiamo la funzione per generare lo slug creata nel Model, passando il title come parametro
		$slug = Project::generateSlug($request->title, '-');

		$form_data['slug'] = $slug;

		//controlliamo prima dell'update se è presente l'indice per salvarci il path da salvare una volta eseguito l'upload
		if ($request->hasFile('cover_image')) {
			//se il progetto ha una cover_image (diversa da null)
			if ($project->cover_image) {
				// cancelliamo la precedente immagine
				Storage::delete($project->cover_image);
			}
			// inseriamo l'immagine nella cartella 'project_images', nella cartella public di storage
			$path = Storage::disk('public')->put('project_images', $request->cover_image);

			$form_data['cover_image'] = $path;
		}

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
