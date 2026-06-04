<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoPremio extends Model
{
    use HasFactory;
      protected $fillable = [
        'grupo_id',
        'posicion',
        'premio',
    ];
     public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
