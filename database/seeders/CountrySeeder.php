<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['name' => 'Afghanistan', 'code' => 'AF'],
            ['name' => 'Albania', 'code' => 'AL'],
            ['name' => 'Algeria', 'code' => 'DZ'],
            ['name' => 'Argentina', 'code' => 'AR'],
            ['name' => 'Australia', 'code' => 'AU'],
            ['name' => 'Austria', 'code' => 'AT'],
            ['name' => 'Belgium', 'code' => 'BE'],
            ['name' => 'Brazil', 'code' => 'BR'],
            ['name' => 'Canada', 'code' => 'CA'],
            ['name' => 'Chile', 'code' => 'CL'],
            ['name' => 'China', 'code' => 'CN'],
            ['name' => 'Colombia', 'code' => 'CO'],
            ['name' => 'Costa Rica', 'code' => 'CR'],
            ['name' => 'Cuba', 'code' => 'CU'],
            ['name' => 'Denmark', 'code' => 'DK'],
            ['name' => 'Ecuador', 'code' => 'EC'],
            ['name' => 'Egypt', 'code' => 'EG'],
            ['name' => 'El Salvador', 'code' => 'SV'],
            ['name' => 'France', 'code' => 'FR'],
            ['name' => 'Germany', 'code' => 'DE'],
            ['name' => 'Greece', 'code' => 'GR'],
            ['name' => 'Guatemala', 'code' => 'GT'],
            ['name' => 'Honduras', 'code' => 'HN'],
            ['name' => 'India', 'code' => 'IN'],
            ['name' => 'Indonesia', 'code' => 'ID'],
            ['name' => 'Ireland', 'code' => 'IE'],
            ['name' => 'Israel', 'code' => 'IL'],
            ['name' => 'Italy', 'code' => 'IT'],
            ['name' => 'Japan', 'code' => 'JP'],
            ['name' => 'Mexico', 'code' => 'MX'],
            ['name' => 'Netherlands', 'code' => 'NL'],
            ['name' => 'New Zealand', 'code' => 'NZ'],
            ['name' => 'Norway', 'code' => 'NO'],
            ['name' => 'Panama', 'code' => 'PA'],
            ['name' => 'Paraguay', 'code' => 'PY'],
            ['name' => 'Peru', 'code' => 'PE'],
            ['name' => 'Poland', 'code' => 'PL'],
            ['name' => 'Portugal', 'code' => 'PT'],
            ['name' => 'Russia', 'code' => 'RU'],
            ['name' => 'South Africa', 'code' => 'ZA'],
            ['name' => 'South Korea', 'code' => 'KR'],
            ['name' => 'Spain', 'code' => 'ES'],
            ['name' => 'Sweden', 'code' => 'SE'],
            ['name' => 'Switzerland', 'code' => 'CH'],
            ['name' => 'Turkey', 'code' => 'TR'],
            ['name' => 'Ukraine', 'code' => 'UA'],
            ['name' => 'United Arab Emirates', 'code' => 'AE'],
            ['name' => 'United Kingdom', 'code' => 'GB'],
            ['name' => 'United States', 'code' => 'US'],
            ['name' => 'Uruguay', 'code' => 'UY'],
            ['name' => 'Venezuela', 'code' => 'VE'],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['code' => $country['code']], // evita duplicados
                ['name' => $country['name']]
            );
        }
    }
}