<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanPrice;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'nombre' => 'amateur',
                'max_grupos' => 1,
                'max_usuarios_por_grupo' => 50,
                'prices' => [
                    ['country_code' => 'CO', 'currency' => 'COP', 'amount' => 249900],
                    ['country_code' => 'EU', 'currency' => 'EUR', 'amount' => 5900],
                    ['country_code' => 'US', 'currency' => 'USD', 'amount' => 6900],
                ],
            ],
            [
                'nombre' => 'professional',
                'max_grupos' => 1,
                'max_usuarios_por_grupo' => 200,
                'prices' => [
                    ['country_code' => 'CO', 'currency' => 'COP', 'amount' => 499900],
                    ['country_code' => 'EU', 'currency' => 'EUR', 'amount' => 11900],
                    ['country_code' => 'US', 'currency' => 'USD', 'amount' => 13900],
                ],
            ],
            [
                'nombre' => 'legend',
                'max_grupos' => 1,
                'max_usuarios_por_grupo' => 500,
                'prices' => [
                    ['country_code' => 'CO', 'currency' => 'COP', 'amount' => 999900],
                    ['country_code' => 'EU', 'currency' => 'EUR', 'amount' => 24900],
                    ['country_code' => 'US', 'currency' => 'USD', 'amount' => 28900],
                ],
            ],
        ];

        foreach ($plans as $planData) {
            $prices = $planData['prices'];
            unset($planData['prices']);

            $plan = Plan::updateOrCreate(
                ['nombre' => $planData['nombre']],
                $planData
            );

            foreach ($prices as $price) {
                PlanPrice::updateOrCreate(
                    [
                        'plan_id' => $plan->id,
                        'country_code' => $price['country_code'],
                    ],
                    [
                        'currency' => $price['currency'],
                        'amount' => $price['amount'],
                        'active' => true,
                    ]
                );
            }
        }
    }
}