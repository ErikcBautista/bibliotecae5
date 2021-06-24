<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libros extends Model
{
    use HasFactory;
    protected $table = 'libros';
    protected $fillable = ['title', 'idioma', 'archivo','description'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function genero()
    {
        return $this->hasOne('App\Models\Generos','id','id_genero_idusu');
    }
}
