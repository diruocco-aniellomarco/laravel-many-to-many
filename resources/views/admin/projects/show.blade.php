@extends('layouts.app')



@section('content')

    <div class="container">
        
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-info my-3">Torna alla lista</a>

        <h1>{{ $project->name }}</h1>
        <div class="row g-3 mt-3">
            <div class="col-2">
                <strong>Slug</strong>
                <p>{{ $project->slug }}</p>
            </div>

            <div class="col-2">
                <strong>Tipi</strong>
                <p>
                    <span class="badge rounded-pill text-bg-primary">{{ $project->type?->label }}</span>
                </p>
            </div>

            <div class="col-4">
                <strong>Link</strong>
                <p>{{ $project->link }}</p>
            </div>
            <div class="col-2">
                <strong>Created at</strong>
                <p>{{ $project->created_at }}</p>
            </div>
            <div class="col-2">
                <strong>Updated at</strong>
                <p>{{ $project->updated_at }}</p>
            </div>

            <div class="col-12">
                <strong>Description</strong>
                <p>{{ $project->description }}</p>
            </div>  
        </div>
        <div class="d-flex mt-3">
            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary">Modifica</a>
            <form action="{{ route('admin.projects.destroy', $project)}}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger mx-3">ELIMINA</button>
            </form>
        </div>  
    </div>
    
@endsection