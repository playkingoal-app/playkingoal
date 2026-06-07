<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PhoneCountryCode;

class PhoneCountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [

            ['country' => 'Afghanistan', 'iso2' => 'AF', 'dial_code' => '+93'],
            ['country' => 'Albania', 'iso2' => 'AL', 'dial_code' => '+355'],
            ['country' => 'Algeria', 'iso2' => 'DZ', 'dial_code' => '+213'],
            ['country' => 'Argentina', 'iso2' => 'AR', 'dial_code' => '+54'],
            ['country' => 'Australia', 'iso2' => 'AU', 'dial_code' => '+61'],
            ['country' => 'Austria', 'iso2' => 'AT', 'dial_code' => '+43'],
            ['country' => 'Belgium', 'iso2' => 'BE', 'dial_code' => '+32'],
            ['country' => 'Bolivia', 'iso2' => 'BO', 'dial_code' => '+591'],
            ['country' => 'Brazil', 'iso2' => 'BR', 'dial_code' => '+55'],
            ['country' => 'Canada', 'iso2' => 'CA', 'dial_code' => '+1'],
            ['country' => 'Chile', 'iso2' => 'CL', 'dial_code' => '+56'],
            ['country' => 'China', 'iso2' => 'CN', 'dial_code' => '+86'],
            ['country' => 'Colombia', 'iso2' => 'CO', 'dial_code' => '+57'],
            ['country' => 'Costa Rica', 'iso2' => 'CR', 'dial_code' => '+506'],
            ['country' => 'Cuba', 'iso2' => 'CU', 'dial_code' => '+53'],
            ['country' => 'Denmark', 'iso2' => 'DK', 'dial_code' => '+45'],
            ['country' => 'Dominican Republic', 'iso2' => 'DO', 'dial_code' => '+1'],
            ['country' => 'Ecuador', 'iso2' => 'EC', 'dial_code' => '+593'],
            ['country' => 'Egypt', 'iso2' => 'EG', 'dial_code' => '+20'],
            ['country' => 'El Salvador', 'iso2' => 'SV', 'dial_code' => '+503'],
            ['country' => 'Finland', 'iso2' => 'FI', 'dial_code' => '+358'],
            ['country' => 'France', 'iso2' => 'FR', 'dial_code' => '+33'],
            ['country' => 'Germany', 'iso2' => 'DE', 'dial_code' => '+49'],
            ['country' => 'Greece', 'iso2' => 'GR', 'dial_code' => '+30'],
            ['country' => 'Guatemala', 'iso2' => 'GT', 'dial_code' => '+502'],
            ['country' => 'Honduras', 'iso2' => 'HN', 'dial_code' => '+504'],
            ['country' => 'India', 'iso2' => 'IN', 'dial_code' => '+91'],
            ['country' => 'Indonesia', 'iso2' => 'ID', 'dial_code' => '+62'],
            ['country' => 'Ireland', 'iso2' => 'IE', 'dial_code' => '+353'],
            ['country' => 'Israel', 'iso2' => 'IL', 'dial_code' => '+972'],
            ['country' => 'Italy', 'iso2' => 'IT', 'dial_code' => '+39'],
            ['country' => 'Japan', 'iso2' => 'JP', 'dial_code' => '+81'],
            ['country' => 'Mexico', 'iso2' => 'MX', 'dial_code' => '+52'],
            ['country' => 'Morocco', 'iso2' => 'MA', 'dial_code' => '+212'],
            ['country' => 'Netherlands', 'iso2' => 'NL', 'dial_code' => '+31'],
            ['country' => 'New Zealand', 'iso2' => 'NZ', 'dial_code' => '+64'],
            ['country' => 'Nigeria', 'iso2' => 'NG', 'dial_code' => '+234'],
            ['country' => 'Norway', 'iso2' => 'NO', 'dial_code' => '+47'],
            ['country' => 'Pakistan', 'iso2' => 'PK', 'dial_code' => '+92'],
            ['country' => 'Panama', 'iso2' => 'PA', 'dial_code' => '+507'],
            ['country' => 'Paraguay', 'iso2' => 'PY', 'dial_code' => '+595'],
            ['country' => 'Peru', 'iso2' => 'PE', 'dial_code' => '+51'],
            ['country' => 'Poland', 'iso2' => 'PL', 'dial_code' => '+48'],
            ['country' => 'Portugal', 'iso2' => 'PT', 'dial_code' => '+351'],
            ['country' => 'Russia', 'iso2' => 'RU', 'dial_code' => '+7'],
            ['country' => 'Saudi Arabia', 'iso2' => 'SA', 'dial_code' => '+966'],
            ['country' => 'South Africa', 'iso2' => 'ZA', 'dial_code' => '+27'],
            ['country' => 'South Korea', 'iso2' => 'KR', 'dial_code' => '+82'],
            ['country' => 'Spain', 'iso2' => 'ES', 'dial_code' => '+34'],
            ['country' => 'Sweden', 'iso2' => 'SE', 'dial_code' => '+46'],
            ['country' => 'Switzerland', 'iso2' => 'CH', 'dial_code' => '+41'],
            ['country' => 'Turkey', 'iso2' => 'TR', 'dial_code' => '+90'],
            ['country' => 'Ukraine', 'iso2' => 'UA', 'dial_code' => '+380'],
            ['country' => 'United Kingdom', 'iso2' => 'GB', 'dial_code' => '+44'],
            ['country' => 'United States', 'iso2' => 'US', 'dial_code' => '+1'],
            ['country' => 'Uruguay', 'iso2' => 'UY', 'dial_code' => '+598'],
            ['country' => 'Venezuela', 'iso2' => 'VE', 'dial_code' => '+58'],

        ];

        PhoneCountryCode::insert($countries);
    }
}