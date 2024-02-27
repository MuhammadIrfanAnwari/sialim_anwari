<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kriteria extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['singkatan', 'nama_kriteria', 'deskripsi'];

    function sub_kriteria(){
        return $this->hasMany(sub_kriteria::class, 'id_kriteria', 'id')->orderBy('nama_sub_kriteria', 'asc');
    }
}
