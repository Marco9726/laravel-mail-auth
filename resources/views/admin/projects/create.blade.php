@extends('layouts.admin')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-10 my-5">
			<h2>Aggiungi nuovo progetto</h2>
		</div>
		<div class="col-2 my-5">
			{{-- link per tornare alla view index --}}
			<a href="{{ route('admin.projects.index')}}" class="btn btn-small btn-warning">Ritorna ai progetti</a>
		</div>
		{{-- se esistiono errori...  --}}
		@if($errors->any())
		<div class="alert alert-danger">
			<ul class="list-unstyled m-0">
			{{-- ...li ciclo e li mostro --}}
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
			</ul>
		</div>
		@endif
		<div class="col-12">
			<form action="{{ route('admin.projects.store')}}" method="POST" enctype="multiplart/form-data">
				@csrf
				{{-- TITLE --}}
				<div class="form-group">
					<label for="inputTitle" class="control-label mb-1 @error('title') text-danger @enderror">Titolo</label>
					<input type="text" id="inputTitle" class="form-control @error('title') is-invalid @enderror" placeholder="Titolo" name="title">
				</div>
				{{-- TYPE_ID  --}}
				<div class="form-group my-3">
					<label for="chooseType" class="control-label mb-1">Linguaggio</label>
					<select id="chooseType" class="form-control" name="type_id"> {{--attributo name = nome della colonna--}}
						<option value="">Seleziona linguaggio</option>
						{{-- ciclo le types --}}
						@foreach ($types as $type)
							<option value="{{ $type->id }}">{{ $type->name }}</option>
						@endforeach
					</select>
				</div>
				{{-- UPLOAD COVER_IMAGE --}}
				<div class="form-group my-3">
					<label for="inputFileImg" class="control-label mb-1 @error('cover_image')text-danger @enderror">Immagine di copertina</label>
					<input id="inputFileImg" type="file" name="cover_image" class="form-control @error('cover_image')is-invalid @enderror">
				</div>
				{{-- TECHNOLOGIES  --}}
				<div class="form-group my-3">
					<div class="control-label mb-1">Tecnologie</div>
					{{-- ciclo le tecnologie --}}
					@foreach ($technologies as $technology)
						<input type="checkbox" value="{{ $technology->id }}" class="form-check-input @error('technologies') is-invalid @enderror" name="technologies[]"> {{--il name è un array, perché potrà contenere più checkbox flaggate--}}
						<label class="form-check-label me-2 @error('technologies') is-invalid @enderror">{{ $technology->name }}</label>
					@endforeach
				</div>
				{{-- DESCRIPTION --}}
				<div class="form-group">
					<label for="inputText" class="control-label mb-1">Descrizione</label>
					<textarea type="text" id="inputText" class="form-control" name="description"> </textarea>
				</div>
				<div class="form-group my-3">
					<button type="submit" class="btn btn-sm btn-success">Salva progetto</button>
				</div>
			</form>
		</div>
	</div>
</div>


@endsection