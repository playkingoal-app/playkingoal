<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCountryCode extends Model
{
    use HasFactory;
    protected $fillable = [
    'country',
    'iso2',
    'dial_code',
];
}
