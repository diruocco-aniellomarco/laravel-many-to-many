<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Type;
use App\Models\Tecnology;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

//attivare se crei una validazione function 
// use Illuminate\Support\Facades\Validator;

use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * *@return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(12);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * *@return \Illuminate\Http\Response
     */
    public function create()
    {   
        $types = Type::all();
        // $project = new Project;
        // $tecnologies = Tecnology::get();
        $tecnologies = Tecnology::all();
        return view('admin.projects.create', compact('types','tecnologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * *@return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    
    {
        //validazione con funzione
        // $data = $this->validation($request->all());
        // $this->validation($data);
        
        // senza la validazione
        // $data = $request->all(); 
        // dd($request->all());

        $data = $request->validated();
        
        $project = new Project();
        $project->fill($data);
        $project->save();

        // Storage::put('cartella_in_cui_caricare', $data['immagine_da_caricare']);
        $cover_image_path = Storage::put("uploads/projects/{$project->id}/cover_image", $data['cover_image']);
        $project->cover_image = $cover_image_path;
        $project->save();

        $project->tecnologies()->attach($data['tecnologies']);
        return redirect()->route('admin.projects.show', $project);
        // aggiungi sul model comic protected $fillable = [array di dati da riempire]
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * *@return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * *@return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $tecnologies = Tecnology::all();
        
        //gli passo un arrray che contienti tutte le tecnologie contenute in un progetto (per farlo comparire "checked" quando lo vado a modificare )
        $teconology_ids = $project->tecnologies->pluck('id')->toArray();

        return view('admin.projects.edit', compact('project','types','tecnologies','teconology_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * *@return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //validazione
        // $data = $this->validation($request->all(), $project->id);
        // $data = $request->all(); senza la validazione

        $data = $request->validated();
        
        // dd($data);

        

        if($request->hasFile('cover_image')){
            if($project->cover_image){
                Storage::delete($project->cover_image);
            }

            $cover_image_path = Storage::put("uploads/projects/{$project->id}/cover_image", $data['cover_image']);
            $project->cover_image = $cover_image_path;
        }
        $project->update($data);

        if(Arr::exists($data, "tecnologies"))
        $project->tecnologies()->sync($data["tecnologies"]);
        else
        $project->tecnologies()->detach();
        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * *@return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {   
        $project->tecnologies()->detach();
        if($project->cover_image){
            Storage::delete($project->cover_image);
        }
        $project->delete();
        return redirect()->route('admin.projects.index');
    }


    public function deleteImage(Project $project)
    {   
        if($project->cover_image) 
        {
        Storage::delete($project->cover_image);
        $project->cover_image = null;
        $project->save();
        }
        return redirect()->back();
    }
    // private function validation($data, $id = null){

    //     $validator = Validator::make(
    //         $data,
    //         [
    //             'name'=> 'required|string',
    //             'description'=> 'required|string|max: 500',
    //             'link'=> 'required|string',
    //             'slug'=> 'required|string',                
    //         ],
    //         [
    //             'name.required'=> 'Il nome è obbligatorio',
    //             'name.string'=> 'Il nome deve essere una stringa',
                
    //             'description.required'=> 'La descrizione è obbligatoria',
    //             'description.string'=> 'La descrizione deve essere una stringa',
    //             'description.max'=> 'La descrizione deve essere massimo di 500 caratteri',
                
    //             'link.required'=> 'Il link è obbligatorio',
    //             'link.string'=> 'Il link deve essere una stringa',
                
    //             'slug.required'=> 'Lo slug è obbligatorio',
    //             'slug.string'=> 'Lo slug deve essere una stringa',
                
    //         ]
    //     )->validate();
    //     return $validator;
    // }
}
