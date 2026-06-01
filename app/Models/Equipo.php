<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'equipos';

     protected $fillable = ['api_id', 'name', 'logo', 'api_league_id'];
	 public function league()
    {
        return $this->belongsTo(ApiLeague::class, 'api_league_id');
    }
}
