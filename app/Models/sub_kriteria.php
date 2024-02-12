<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sub_kriteria extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['id_kriteria', 'nama_sub_kriteria', 'deskripsi'];

    function kriteria(){
        return $this->belongsTo(kriteria::class, 'id_kriteria', 'id')->withTrashed();
    }
}
