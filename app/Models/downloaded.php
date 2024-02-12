<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class downloaded extends Model
{
    use HasFactory;

    protected $fillable = ['ip', 'id_dokumen', 'tanggal'];

    public $timestamps = false;

    function dokumen(){
        return $this->belongsTo(dokumen::class, 'id_dokumen', 'id');
    }
}
