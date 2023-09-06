<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteMovie extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'movie_id',
        'movie_name'
    ];

    
    protected $table = 'favorite_movie';

    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }
}
