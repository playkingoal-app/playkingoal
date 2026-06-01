<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLeague extends Model
{
    use HasFactory;

    protected $table = 'api_leagues';
    protected $fillable = ['api_id', 'name', 'country', 'logo'];
}
