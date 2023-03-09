@extends('layouts.admin')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-10 my-5">
			<h2>Dettagli progetto {{ $project->title }}</h2>
		</div>
		<div class="col-2 my-5">
			<a href="{{ route('admin.projects.index')}}" class="btn btn-small btn-warning">Ritorna ai progetti</a>
		</div>
		<div class="col-12">
			<img src="{{ asset('storage/' . $project->cover_image )}}" alt="{{ $project->title }}" class="w-50 mb-2">
			<p><strong>Slug: </strong>{{ $project->slug }}</p>
			<p><strong>Linguaggio: </strong>{{ $project->type ? $project->type->name : 'Non specificato' }}</p>
			<p><strong>Tecnologie: </strong>
				{{-- se sono presenti, ciclo le tecnologie  --}}
				@forelse ($project->technologies as $technology)
					@if (!$loop->last) {{--se non sono nell'ultima iterazione, aggiungo una virgola dopo il valore ciclato--}}
						{{ $technology->name }},
					@else 
						{{ $technology->name }}
					@endif
				@empty
					Non ci sono tecnologie associate
				@endforelse
			</p>
			<p><strong>Descrizione: </strong>{{ $project->description }}</p>
		</div>
	</div>
</div>


@endsection