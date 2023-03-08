@extends('layouts.admin')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-12 my-5">
			<h2>Tecnologie</h2>
		</div>
		{{-- ERRORI  --}}
		@if(session('message')) 
			<div class="alert alert-success">
				{{ session('message') }}
			</div>
		@endif
		<div class="col-12">
			<table class="table table-striped">
				<thead>
					<th>Id</th>
					<th>Nome</th>
					<th>Slug</th>
					<th>Azioni</th>
				</thead>
				<tbody>
					@foreach ($technologies as $technology)
					<tr>
						<td>{{ $technology->id }}</td>
						<td>{{ $technology->name }}</td>
						<td>{{ $technology->slug }}</td>
						<td>
							{{-- link alla view show per visualizzare la tecnologia --}}
							<a href="{{ route('admin.technologies.show' , $technology->slug )}}" title="Visualizza tecnologia" class="btn btn-sm btn-primary">
								<i class="fas fa-eye"></i>
							</a>
							{{-- link alla view edit per modificare la tecnologia --}}
							{{-- <a href="{{ route('admin.technologies.edit' , $technology->slug )}}" title="Modifica tecnologia" class="btn btn-sm btn-warning">
								<i class="fas fa-edit"></i>
							</a> --}}
							{{-- form con button per eliminare la tecnologia --}}
							<form action="{{ route('admin.technologies.destroy', $technology->slug )}}" class="d-inline-block" method="POST">
								@csrf
								@method('DELETE')
								<button technology="submit" class="btn btn-sm btn-danger">
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
