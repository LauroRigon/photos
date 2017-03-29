<?php

namespace App\Http\Controllers;

use App\Album;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
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
        return view('tests.albumCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * vars name, user_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(User::userExist($request->user_id) && Album::where('name', $request->name)->where('user_id', $request->user_id)->first() == null) {
            $album = new Album();
            $album->name = $request->name;
            $album->user_id = $request->user_id;
            $album->save();

            return response()->json([
                'status' => 'success',
                'msg' => "Album salvo com sucesso!"
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'msg' => "Usuário não existe ou este album já existe!"
            ]);
        }
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
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $album = Album::find($id);

        /*Verifica se user pode modificar album*/
        /*if(Auth::id() != $album->user_id || Auth::user()->isAdmin != 1){
            return response()->json([
                'status' => 'error',
                'msg' => "Sem permissão para alterar album!"
            ]);
        }*/

        $album->fill($data);

        if($album->save() != null){
            return response()->json([
                'status' => 'success',
                'msg' => "Album atualizado com sucesso!"
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'msg' => "Um erro ocorreu ao salvar!"
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $albumID)
    {
        if(Album::canDestroy($albumID->user_id)){
            if($albumID->deleteAlbumPhotos($albumID)){
                if($albumID->delete()){
                    return response()->json([
                        'status' => 'success',
                        'msg' => "Album deletado com sucesso!"
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 'error',
                    'msg' => "Erro ao deletar!"
                ]);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'msg' => "Sem permissão para esta ação!"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete()
    {
        return view('tests.albumDelete');
    }
}
