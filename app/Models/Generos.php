<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generos extends Model
{
    use HasFactory;
    protected $table = 'generos';
    protected $fillable = ['nombre'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function libro()
    {
        return $this->hasMany('App\Models\Libros');
    }
}
