<?php

namespace App\Http\Controllers;
use Input;
use Illuminate\Support\Facades\Auth;
use App\Album;
use Intervention\Image\Facades\Image;
use App\Photo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use Mockery\CountValidator\Exception;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tests.sendphotoform');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * vars photos, user_id, album_id
     * @return \Illuminate\Http\Response    JSON com status e MSG
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //var_dump(Album::find($data['album_id'])->user_id);
        $album = Album::find($data['album_id']);
        if($album == null || $album->user_id != $data['user_id']){       // verifica se o album é do usuário e se ele existe
            return response()->json([
                'status' => 'error',
                'msg' => "Esse album não existe!"
            ]);
        }

        if($request->hasFile('photos')){
            $files = $request->file('photos');
            File::exists(storage_path('uploads/' . $data['user_id'])) or File::makeDirectory(storage_path('uploads/' . $data['user_id']), $mode = 0755, $recursive = false, $force = false);

            foreach ($files as $file) {
                $fileName = $file->getClientOriginalName();

                $store = Storage::put("{$data['user_id']}/" . $fileName, file_get_contents($file));
                $photo = Photo::where('img', $fileName)->where('user_id', $data['user_id'])->first();

                if($store == true && $photo == null){
                    $photo = new Photo();
                    $photo->name = $fileName;
                    $photo->user_id = $data['user_id'];
                    $photo->album_id = $data['album_id'];
                    $photo->img = $fileName;
                    try {
                        $photo->save();
                    }catch(Exception $e){
                        return response()->json([
                            'status' => 'error',
                            'msg' => "Erro ao salvar imagem {$fileName}, verifique as informações e tente novamente!"
                        ]);
                    }
                }elseif ($store == true){
                    //update
                    $photo->name = $fileName;
                    $photo->user_id = $data['user_id'];
                    $photo->album_id = $data['album_id'];
                    $photo->img = $fileName;
                    try {
                        $photo->save();
                    }catch(Exception $e){
                        return response()->json([
                            'status' => 'error',
                            'msg' => "Erro ao atualizar imagem {$fileName}, verifique as informações e tente novamente!"
                        ]);
                    }
                }
            }
        }else{
            return response()->json([
                'status' => 'error',
                'msg' => 'Nenhuma imagem passada!'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'As imagens foram salvas com sucesso!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photoID)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $photoID
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photoID)
    {
        $path = Auth::id() . '/' . $photoID->img;

        $deleteImg = Storage::delete($path);
        if($deleteImg == true) {
            $photoID->delete();

            return response()->json([
                'status' => 'success',
                'msg' => "A imagem {$photoID->name} foi removida com sucesso!"
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'msg' => "Erro ao deletar a imagem {$photoID->name}, por favor tente novamente!"
            ]);
        }
    }

    public function get($filename){
        $path = storage_path("uploads/" . Auth::id() . "/" . $filename);
        return Image::make($path)->resize(100, 100)->response();
    }
}
