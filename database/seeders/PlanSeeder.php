<?php

namespace Database\Seeders;

use App\Models\BillingCycle;
use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dummy = [
            'plans' => [
                'basic' => [
                    'name' => 'basic',
                    'title' => 'Basic Plan',
                    'price' => '25.000,-',
                    'period' => '/ weeks',
                    'description' => 'Perfect for small events where you want to engage guests with real-time messages displayed on big screens.',
                    'features' => [
                        'Maximum of 2 Events',
                        '5.000 Messages',
                        'Customizable message bubble colors, fonts, and sizes',
                        'IP & Email Tracking',
                        'Up to 100 MB storage',
                    ],
                ],
                'standard' => [
                    'name' => 'standard',
                    'title' => 'Standard Plan',
                    'price' => '40.000,-',
                    'period' => '/ weeks',
                    'popular' => 'Most Popular',
                    'description' => 'A perfect package for multi-day events like club nights, corporate events, and small festivals.',
                    'features' => [
                        'Maximum of 4 Events',
                        '25.000 Messages',
                        'Full Customization (Bubble & Background)',
                        'Send Image Attachments (up to 10 MB / file)',
                        'IP & Email Tracking',
                        'Up to 300 MB storage',
                    ],
                ],
                'premium' => [
                    'name' => 'premium',
                    'title' => 'Premium Plan',
                    'price' => '100.000,-',
                    'period' => '/ weeks',
                    'description' => 'Best solution for large festivals and recurring events with custom animations and more storage for interactive experiences.',
                    'features' => [
                        'Maximum of 6 Events',
                        '100.000 Messages',
                        'Full Customization (Bubble & Background)',
                        'Animations Effect Features',
                        'Chats Themes',
                        'Send Image Attachments (up to 15 MB / file)',
                        'IP & Email Tracking',
                        'Up to 1 GB storage',
                    ],
                ],
            ],
        ];

        foreach ($dummy['plans'] as $key => $planData) {
            $plan = Plan::create([
                'name'        => $planData['name'],
                'title'       => $planData['title'],
                'features'    => json_encode($planData['features']),
            ]);

            $cycles = [];
            switch ($key) {
                case 'basic':
                    $cycles = [
                        ['cycle' => 'one_week', 'price' => 25000],
                        ['cycle' => 'two_weeks', 'price' => 50000],
                        ['cycle' => 'one_month', 'price' => 100000],
                        ['cycle' => 'three_months', 'price' => 300000],
                    ];
                    break;
                case 'standard':
                    $cycles = [
                        ['cycle' => 'one_week', 'price' => 40000],
                        ['cycle' => 'two_weeks', 'price' => 80000],
                        ['cycle' => 'one_month', 'price' => 160000],
                        ['cycle' => 'three_months', 'price' => 480000],
                    ];
                    break;
                case 'premium':
                    $cycles = [
                        ['cycle' => 'one_week', 'price' => 100000],
                        ['cycle' => 'two_weeks', 'price' => 200000],
                        ['cycle' => 'one_month', 'price' => 400000],
                        ['cycle' => 'three_months', 'price' => 1200000],
                    ];
                    break;
            }

            foreach ($cycles as $cycle) {
                BillingCycle::create([
                    'plan_id' => $plan->id,
                    'cycle'   => $cycle['cycle'],
                    'price'   => $cycle['price'],
                ]);
            }
        }

    }
}
