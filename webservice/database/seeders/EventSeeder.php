<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::query()->create([
            'name' => 'Gamification for E-Commerce',
            'address' => 'Jl. H.R Rasuna Said Generali Tower, Gran Rubina Business Park, Karet Kuningan, Jakarta',
            'date' => date('Y-m-d', strtotime('+10 days')),
            'image_url' => 'events/1.jpeg',
            'description' => 'Pinduoduo: From Zero to $23B in Three Years. How gamification of ecommerce made it possible'
        ]);
        Event::query()->create([
            'name' => 'Test Engineer Workshop',
            'address' => 'Jl. Raja Sulaiman No 110, Surabaya',
            'date' => date('Y-m-d', strtotime('+10 days')),
            'image_url' => 'events/2.jpeg',
            'description' => 'Learn to be a Test Engineer with Tokopedia Experts'
        ]);
    }
}
