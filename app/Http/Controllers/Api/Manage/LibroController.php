<?php

namespace App\Http\Controllers\Api\Manage;

use App\Http\Controllers\Controller;
use App\Models\Libros;
use Illuminate\Http\Request;
use App\Http\Requests\Manage\LibrosRequest;
use App\Http\Resources\Manage\LibrosResource;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Libros::all();
        return LibrosResource::collection(Libros::all()->where("aprobado",true));//latest()->paginate());
    }
    public function store(LibrosRequest $request)
    {
        $request -> validated(); //validad datos
        $user = Auth::user();//obtener usuario autenticado
        $post = new Libros();
        $post -> user()->associate($user);//asociar el post con el usuario
        $url_image = $this ->upload($request->file('archivo'));
        $post->archivo = $url_image;
        $post->title = $request->input('title');
        $post->idioma = $request->input('idioma');
        $post->description = $request->input('description');
        $post -> aprobado = false;
        $res = $post->save();
        if($res){
            return response()->json(['message'=>'Libro creado exitosamente'], 201);
        }else{
            return response()->json(['message'=>'No se ha podido subir el libro'], 500);
        }
        
    }
    private function upload($image){
        $path_info = pathinfo($image->getClientOriginalName());
        $post_path = 'images/post';
        $rename = uniqid().'.'.$path_info['extension'];
        $image->move(public_path()."./$post_path", $rename);
        return "$post_path/$rename";

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($post)
    {
        
        if(Libros::where('id',$post)->exists()) {
            //return Libros::where('id',$post)->get();
            
            $res = DB::table('libros')
                ->select('libros.id','libros.title','libros.idioma','libros.description','libros.archivo as photo','users.name as author', 'users.email','libros.created_at')
                ->join('users','users.id','libros.user_id')
                ->where('libros.id',$post)->get();
            return response()->json($res, 200);
            
        }else{
            return response()->json([
                'message' => 'Post no encontrado'
            ], 404);
        }
        
        //return new LibrosResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $post = Libros::find($id);
        Validator::make($request->all(), [
            'title' => 'max:50',
            'image' => 'image|max:1024',
            'description' => 'max:200',
        ])->validate();
        if(Auth::user()->rol == "Cliente")
        {
            if(Auth::id() !== $post->user->id){
                return response()-> json([
                    'message' => "Lo sentimos, el post no te pertenece"
                ], 403);
            }
        }
        if(!empty($request->input('title'))){
            $post -> title= $request->input('title');
        }
        if(!empty($request->file('image'))){
            $url_image = $this->upload($request->file('image'));
            $post -> image = $url_image;
        }
        if(!empty($request->input('description'))){
            $post -> description= $request->input('description');
        }
        if(Auth::user()->rol == "Admin")
        {
            if(!empty($request->input('aprobado')) && $request->input('aprobado') != "0" ){
                $post -> aprobado = true;
            }else{
                $post -> aprobado = false;
            }
        }
        $res = $post -> save(); // actualizamos los datos en la base de datos

        if($res){
            return response() -> json([
                'message' => 'Felicidades, post actualizado con exito'
            ]);
        }else{
            return response() -> json([
                'message' => 'Lo sentimos, hubo un error al actualizar el post'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->rol == "Cliente")
        {
            if(Auth::id() !== $post->user->id){
                return response()-> json([
                    'message' => "Lo sentimos, el post no te pertenece"
                ], 403);
            }
        }
        if( Libros::where('id',$id)->count()>0)
        {
            Libros::destroy($id);
            return response()->json([
                'message' => 'Libro eliminado'
            ], 200);
        }
        else
        {
            return response()->json([
                'message' => 'este libro ya fue eliminado'
            ]);
        }
    }
    public function __construct()
    {
        //aqui se indica que el middleware auth:api no hara caso si esta o no autorizado un usuario
        $this->middleware('auth:api', [
            'except' =>['index','show']
        ]);
    }
}
