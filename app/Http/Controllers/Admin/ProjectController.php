<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Type;
use App\Models\Tecnology;

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
        return view('admin.projects.edit', compact('project','types'));
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
        
        $project->update($data);
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
        $project->delete();
        return redirect()->route('admin.projects.index');
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
