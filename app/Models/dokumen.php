<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class dokumen extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['id_user', 'id_sub_kriteria', 'id_bagian', 'dokumen', 'judul', 'status', 'privasi'];

    function sub_kriteria(){
        return $this->belongsTo(sub_kriteria::class, 'id_sub_kriteria', 'id')->withTrashed();
    }

    function bagian(){
        return $this->belongsTo(bagian::class, 'id_bagian', 'id')->withTrashed();
    }

    function user(){
        return $this->belongsTo(User::class, 'id_user', 'id')->withTrashed();
    }
}
