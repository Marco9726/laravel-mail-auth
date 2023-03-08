@extends('layouts.admin')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-10 my-5">
			<h2>Dettagli linguaggio {{ $type->name }} <i class="fa-brands fa-{{ $typesIcons[ $type->name ] }}"></i></h2>
		</div>
		<div class="col-2 my-5">
			<a href="{{ route('admin.types.index')}}" class="btn btn-small btn-warning">Ritorna ai linguaggi</a>
		</div>
		<div class="col-12">
			<p><strong>Slug: </strong>{{ $type->slug }}</p>
		</div>
		<hr class="{{ $type->slug}}-border">
		<div class="col-12">
			<h3>Progetti creati</h3>
			<div class="row mt-3">
				@forelse ($type->projects as $project)
					<div class="col-4 px-2 mb-3">
						<div class="card {{ $type->slug}}-border">
							<div class="card-body">
								<h5 class="card-title">{{ $project->title }}</h5>
								<p class="card-text">{{ $project->description }}</p>
							</div>
						</div>
					</div>
				@empty
					<h3 class="text-center">Non sono presenti progetti che utilizzano questo linguaggio</h3>
				@endforelse
			</div>
		</div>
	</div>
</div>


@endsection