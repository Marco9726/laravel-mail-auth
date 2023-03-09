@extends('layouts.admin')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-10 my-5">
			<h2>Modifica il progetto progetto</h2>
		</div>
		<div class="col-2 my-5">
			{{-- link per tornare alla view index --}}
			<a href="{{ route('admin.projects.index')}}" class="btn btn-small btn-warning">Ritorna ai progetti</a>
		</div>
		@if($errors->any())
		<div class="alert alert-danger">
			<ul class="list-unstyled m-0">
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
			</ul>
		</div>
		@endif
		<div class="col-12">
			<form action="{{ route('admin.projects.update', $project->slug)}}" method="POST" enctype="multiplart/form-data">
				@csrf
				@method('PUT')
				{{-- TITLE --}}
				<div class="form-group mb-3">
					<label for="inputTitle" class="control-label mb-1 @error('title') text-danger @enderror">Titolo</label>
					<input type="text" id="inputTitle" class="form-control @error('title') is-invalid @enderror" placeholder="Titolo" name="title" value="{{ old('title') ?? $project->title }}">
				</div>
				{{-- TYPE_ID --}}
				<div class="form-group">
					<label for="chooseType" class="control-label mb-1">Linguaggio</label>
					<select id="chooseType" class="form-control" name="type_id"> {{--attributo name = nome della colonna--}}
						<option value="">Seleziona linguaggio</option>
						{{-- ciclo le types --}}
						@foreach ($types as $type)
							<option value="{{ $type->id }}" {{ $type->id == old('type_id', $project->type_id) ? 'selected' : ''}}>{{ $type->name }}</option>
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
						@if($errors->any())
						{{-- PRIMO CASO: Errori di modifica, visualizzo le check selezionate  e ne evidenzio gli errori--}}
						<input type="checkbox" value="{{ $technology->id }}" class="form-check-input @error('technologies') is-invalid @enderror" name="technologies[]" {{ in_array( $technology->id, old('technologies', [])) ? 'checked' : '' }}>
						<label class="form-check-label me-2 @error('technologies') is-invalid @enderror">{{ $technology->name }}</label>
						@else
						{{--SECONDO CASO: Pagina edit appena aperta, mostro le check attualmente associate al project --}}
						<input type="checkbox" value="{{ $technology->id }}" class="form-check-input @error('technologies') is-invalid @enderror" name="technologies[]" {{ $project->technologies->contains($technology) ? 'checked' : '' }}>
						<label class="form-check-label me-2 @error('technologies') is-invalid @enderror">{{ $technology->name }}</label>
						@endif
					@endforeach
				</div>
				{{-- DESCRIPTION --}}
				<div class="form-group">
					<label for="inputText" class="control-label mb-1">Descrizione</label>
					<textarea type="text" id="inputText" class="form-control" name="description">{{ old('description') ?? $project->description }} </textarea>
				</div>
				<div class="form-group my-3">
					<button type="submit" class="btn btn-sm btn-success">Salva modifiche</button>
				</div>

			</form>
		</div>
	</div>
</div>


@endsection