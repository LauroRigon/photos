<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use App\Photo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'name',
        'user_id'
        ];

    public function canCreate($user_id){
        if(Auth::id() == $user_id){
            return true;
        }else{
            return false;
        }
    }

    public static function canDestroy($user_id){
        if(Auth::id() == $user_id || Auth::user()->isAdmin == 1){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Delete all photos of the album
     * @param Object $album
     * @return bool
     */
    public static function deleteAlbumPhotos($albuns){
        foreach ($albuns as $album) {
            $photos = Photo::where('album_id', $album->id)->get();
            foreach ($photos as $photo) {
                Storage::delete($album->user_id . '/' . $photo->name);
            }
        }
        return true;
    }
}
