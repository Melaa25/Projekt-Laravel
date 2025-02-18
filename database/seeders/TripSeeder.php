<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;

class TripSeeder extends Seeder
{
    public function run()
    {
        Trip::insert([
            [
                'name' => 'Mountain Adventure',
                'description' => 'A thrilling mountain adventure with breathtaking views.',
                'start_date' => '2025-06-01',
                'end_date' => '2025-06-10',
                'price' => 1200.00,
                'category_id' => 1, // ID istniejącej kategorii
                'guide_id' => 1,    // ID istniejącego przewodnika
            ],
            [
                'name' => 'Tropical Beach Getaway',
                'description' => 'Relax on sunny beaches and enjoy crystal clear water.',
                'start_date' => '2025-07-01',
                'end_date' => '2025-07-10',
                'price' => 1500.00,
                'category_id' => 2,
                'guide_id' => 2,
            ],
            [
                'name' => 'City Tour',
                'description' => 'Explore the history and culture of a bustling city.',
                'start_date' => '2025-08-01',
                'end_date' => '2025-08-05',
                'price' => 800.00,
                'category_id' => 3,
                'guide_id' => null,
            ],
            [
                'name' => 'Safari Adventure',
                'description' => 'Experience the thrill of a safari in the wild.',
                'start_date' => '2025-09-15',
                'end_date' => '2025-09-25',
                'price' => 2000.00,
                'category_id' => 1,
                'guide_id' => 1,
            ],
            [
                'name' => 'Cruise Vacation',
                'description' => 'Sail across the seas on a luxurious cruise.',
                'start_date' => '2025-05-20',
                'end_date' => '2025-05-30',
                'price' => 2500.00,
                'category_id' => 1,
                'guide_id' => 1,
            ],
            [
                'name' => 'Cultural Exploration',
                'description' => 'Dive into the culture of an exotic location.',
                'start_date' => '2025-10-01',
                'end_date' => '2025-10-10',
                'price' => 900.00,
                'category_id' => 1,
                'guide_id' => 1,
            ],
            [
                'name' => 'Skiing Holiday',
                'description' => 'Hit the slopes for an exciting skiing holiday.',
                'start_date' => '2025-12-15',
                'end_date' => '2025-12-22',
                'price' => 1800.00,
                'category_id' => 1,
                'guide_id' => null,
            ],
            [
                'name' => 'Jungle Expedition',
                'description' => 'Embark on a thrilling jungle expedition.',
                'start_date' => '2025-03-01',
                'end_date' => '2025-03-10',
                'price' => 1700.00,
                'category_id' => 1,
                'guide_id' => 1,
            ],
            [
                'name' => 'Desert Adventure',
                'description' => 'Discover the beauty of the desert on this adventure.',
                'start_date' => '2025-04-10',
                'end_date' => '2025-04-20',
                'price' => 1300.00,
                'category_id' => 1,
                'guide_id' => 1,
            ],
            [
                'name' => 'Island Escape',
                'description' => 'Relax on a beautiful island getaway.',
                'start_date' => '2025-08-15',
                'end_date' => '2025-08-25',
                'price' => 2200.00,
                'category_id' => 1,
                'guide_id' => 1,
            ],
            [
                'name' => 'Historical Journey',
                'description' => 'Step back in time with this historical journey.',
                'start_date' => '2025-06-20',
                'end_date' => '2025-06-30',
                'price' => 1100.00,
                'category_id' => 1,
                'guide_id' => 1,
            ],
            [
                'name' => 'Extreme Adventure',
                'description' => 'For thrill-seekers looking for extreme adventure.',
                'start_date' => '2025-07-10',
                'end_date' => '2025-07-15',
                'price' => 2500.00,
                'category_id' => 1,
                'guide_id' => null,
            ],
            [
                'name' => 'Wine Tasting Tour',
                'description' => 'Enjoy the finest wines on this exclusive tour.',
                'start_date' => '2025-09-05',
                'end_date' => '2025-09-10',
                'price' => 1400.00,
                'category_id' => 1,
                'guide_id' => 1,
            ],
            [
                'name' => 'Camping Retreat',
                'description' => 'Escape to nature with this camping retreat.',
                'start_date' => '2025-10-15',
                'end_date' => '2025-10-20',
                'price' => 700.00,
                'category_id' => 1,
                'guide_id' => null,
            ],
            [
                'name' => 'Luxury Getaway',
                'description' => 'Indulge in luxury on this exclusive getaway.',
                'start_date' => '2025-11-01',
                'end_date' => '2025-11-10',
                'price' => 3000.00,
                'category_id' => 1,
                'guide_id' => 1,
            ],
        ]);
    }
}
