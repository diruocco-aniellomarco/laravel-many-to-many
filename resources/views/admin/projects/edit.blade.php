@extends('layouts.app')

@section('css')
    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')

    <div class="container">
        
        <h1 class="my-3">Modifica questo progetto</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            <h4>Correggi i seguenti errori per proseguire:</h4>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
         @endif

        <div class="row">
            <div class="col-8">
                <form class="row g-3 mt-4" action="{{ route('admin.projects.update', $project )}}" method="POST" enctype="multipart/form-data">
                    {{-- token da inserire per farlo leggere a laravel (questioni di sicurezza) --}}
                    @csrf
                    @method('PUT')
                    <div class="col-4">
                        <label class="d-block" for="name">Nome</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{old('name', $project->name)}}">
                    </div>

                    <div class="col-4">
                        <label class="d-block" for="type_id">Tipo</label>
                        <select class="form-select" aria-label="Default select example" name="type_id" id="type_id">
                            @foreach ($types as $type)
                                <option value="{{$type->id}}">{{$type->label}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-4">
                        <label class="d-block" for="link">Link</label>
                        <input type="text" id="link" name="link" class="form-control" value="{{old('link', $project->link)}}">
                    </div>

                    <div class="col-6">
                        <label class="d-block" for="cover_image">Cover</label>
                        <input class="form-control" type="file" id="cover_image" name="cover_image" value="{{old('cover_image')}}">
                    </div>

                    <div class="col-6">

                        <label class="form-label">Tecnologia:</label>

                        <div class="form-check @error('tecnologies') is-invalid @enderror p-0">
                            @foreach ($tecnologies as $tecnology)

                                <span class="me-3">
                                    <input
                                    type="checkbox"
                                    id="tecnology-{{ $tecnology->id }}"
                                    value="{{ $tecnology->id }}"
                                    name="tecnologies[]"
                                    class="form-check-control"
                                    @if (in_array($tecnology->id, old('tecnologies', $teconology_ids ?? []))) checked @endif
                                    >
                                    <label for="tecnology-{{ $tecnology->id }}">
                                    {{ $tecnology->name }}
                                    </label>
                                </span>
                                
                            @endforeach
                        </div>

                    </div>
                    <div class="col-12">
                        <label class="d-block" for="slug">Slug</label>
                        <input type="text" id="slug" name="slug" class="form-control" value="{{old('slug', $project->slug)}}">
                    </div>
                    <div class="col-12">
                        <label class="d-block" for="description">Descrizione</label>
                        <input type="text" id="description" name="description" class="form-control" value="{{old('description', $project->description)}}">
                    </div>
                    <div class="col-6">
                        <button class="btn btn-success">SALVA</button>
                        <a href="{{ route('admin.projects.index')}}" class="btn btn-warning">ANNULLA</a>
                    
                    </div>
                </form>
            </div>

            <div class="col-4 ">
                @if ($project->cover_image)
                    <div class="position-relative">
                        <img src="{{asset('/storage/'. $project->cover_image)}}" alt="" class="image-fluid " id="cover_image_preview">
                    
                        {{--  --}}
                        <form action="{{route('admin.projects.delete-image', $project)}}" method="POST" class="position-absolute top-0 ">
                            @csrf
                            @method('DELETE')
                            <button id="button-delete-edit" class="bg-danger text-light badge rounded-pill translate-middle bg-danger">
                                <i class="fa-solid fa-trash "></i>
                            </button>
                        </form>
                    </div>
                @else
                    <img src="https://placehold.co/400" alt="" class="image-fluid " id="cover_image_preview">
                @endif
                
            </div>
        </div>
        
    </div>
    
@endsection

@section('scripts')
<script type="text/javascript"> 
    // mi aggancio alla input della sezione "Cover"
    const inputFileElement = document.getElementById('cover_image');
    // mi aggancio alla img dove si trova l'immagine caricata/da caricare
    const coverImagePreview = document.getElementById('cover_image_preview');

    // quando l'input della sezione Cover, cambia allora...
    inputFileElement.addEventListener('change', function(){
        //prendi la sezione files di questo progetto
        const [file] = this.files;
        
        //tramite l'ibreria "URL.createObjectURL( )" crea un url temporaneo dell'immagine che si trova in "files"
        coverImagePreview.src = URL.createObjectURL(file);
    })
</script>

@endsection