<?php

namespace App\Http\Controllers;

use App\Album;
use App\User;
use Illuminate\Http\Request;

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
     * vars name, album_id
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
        //
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
