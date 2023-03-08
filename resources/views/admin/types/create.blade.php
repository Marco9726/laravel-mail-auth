@extends('layouts.admin')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-10 my-5">
			<h2>Aggiungi nuovo linguaggio</h2>
		</div>
		<div class="col-2 my-5">
			{{-- link per tornare alla view index --}}
			<a href="{{ route('admin.types.index')}}" class="btn btn-small btn-warning">Ritorna ai linguaggi</a>
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
			<form action="{{ route('admin.types.store')}}" method="POST">
				@csrf
				{{-- NAME --}}
				<div class="form-group mb-3">
					<label for="inputName" class="control-label mb-1">Nome</label>
					<input type="text" id="inputName" class="form-control" placeholder="Nome linguaggio" name="name">
				</div>
				<div class="form-group my-3">
					<button type="submit" class="btn btn-sm btn-success">Salva linguaggio</button>
				</div>
			</form>
		</div>
	</div>
</div>


@endsection