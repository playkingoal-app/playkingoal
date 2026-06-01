<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code'
    ];
     public function getFlagAttribute()
    {
        if (!$this->code) {
            return '';
        }

        return collect(str_split(strtoupper($this->code)))
            ->map(fn ($letter) => mb_chr(ord($letter) + 127397))
            ->implode('');
    }
}
