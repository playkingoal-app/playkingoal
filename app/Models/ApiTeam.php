<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiTeam extends Model
{
    use HasFactory;

    protected $table = 'api_teams';
    protected $fillable = ['api_id', 'name', 'logo', 'api_league_id'];
      // Relación con la liga
    public function league()
    {
        return $this->belongsTo(ApiLeague::class, 'api_league_id');
    }
}
