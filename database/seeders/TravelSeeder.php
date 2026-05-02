<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Destination;
use App\Models\Faq;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TravelSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@travel.test'],
            [
                'name' => 'Travel Admin',
                'password' => Hash::make('password'),
            ]
        );

        $destinations = Destination::factory()->count(4)->create();

        $destinations->each(function (Destination $destination) {
            Trip::factory()->count(3)->create([
                'destination_id' => $destination->id,
            ]);
        });

        BlogPost::factory()->count(4)->create();
        Faq::factory()->count(5)->create();
    }
}
