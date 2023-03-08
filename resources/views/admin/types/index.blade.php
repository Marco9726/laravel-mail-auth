@extends('layouts.admin')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-10 my-5">
			<h2>Linguaggi</h2>
		</div>
		{{-- link alla view create per creare un nuovo linguaggio  --}}
		{{-- <div class="col-2 my-5">
			<a href="{{ route('admin.types.create')}}" class="btn btn-small btn-success">Aggiungi linguaggio</a>
		</div> --}}
		{{-- //visualizza messaggio di conferma in caso venga aggiunto correttamente un nuovo linguaggio --}}
		@if(session('message')) 
			<div class="alert alert-success">
				{{ session('message') }}
			</div>
		@endif
		{{-- --}}
		<div class="col-12">
			<table class="table table-striped">
				<thead>
					<th>Id</th>
					<th>Titolo</th>
					<th>Logo</th>
					<th>Slug</th>
					<th>Progetti Creati</th>
					<th>Azioni</th>
				</thead>
				<tbody>
					@foreach ($types as $type)
					<tr>
						<td>{{ $type->id }}</td>
						<td>{{ $type->name }}</td>
						<td><i class="fa-brands fa-{{ $typesIcons[ $type->name ] }}"></td>
						<td>{{ $type->slug }}</td>
						<td>{{ count( $type->projects ) }}</td>
						<td>
							{{-- link alla view show per visualizzare il linguaggio --}}
							<a href="{{ route('admin.types.show' , $type->slug )}}" title="Visualizza linguaggio" class="btn btn-sm btn-primary">
								<i class="fas fa-eye"></i>
							</a>
							{{-- link alla view edit per modificare il linguaggio --}}
							{{-- <a href="{{ route('admin.types.edit' , $type->slug )}}" title="Modifica linguaggio" class="btn btn-sm btn-warning">
								<i class="fas fa-edit"></i>
							</a> --}}
							{{-- form con button per eliminare il linguaggio --}}
							<form action="{{ route('admin.types.destroy', $type->slug )}}" class="d-inline-block" method="POST">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-sm btn-danger">
									<i class="fas fa-trash"></i>
								</button> 
							</form>
						</td>
					</tr>
					@endforeach
	
				</tbody>
			</table>
		</div>
	</div>
</div>
{{-- @include('partials.modal') includo la modal --}}
@endsection
