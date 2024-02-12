<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class validasi extends Model
{
    use HasFactory;

    protected $fillable = ['id_user', 'id_dokumen', 'alasan', 'status'];

    function dokumen(){
        return $this->belongsTo(dokumen::class, 'id_dokumen', 'id')->withTrashed();
    }
}
