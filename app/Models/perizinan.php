<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perizinan extends Model
{
    use HasFactory;

    protected $fillable = ['id_user', 'id_dokumen'];

    protected $table = 'perizinan';

    function user(){
        return $this->belongsTo(User::class, 'id_user', 'id')->withTrashed();
    }

    function dokumen(){
        return $this->belongsTo(dokumen::class, 'id_dokumen', 'id')->withTrashed();
    }
}
