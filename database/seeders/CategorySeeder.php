<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Politics',
            'Business',
            'Technology',
            'Health',
            'Science',
            'Education',
            'Environment',
            'Sports',
            'Entertainment',
            'Art & Culture',
            'Travel',
            'Food',
            'Lifestyle',
            'Finance',
            'World',
            'Local News',
            'Automotive',
            'Real Estate',
            'History',
            'Fashion',
            'Gaming',
            'Parenting',
            'Religion',
            'Social Issues',
            'Opinion',
            'Books',
            'Weather',
            'Agriculture',
            'Cybersecurity',
            'Startups',
            'Space Exploration',
            'Wellness',
            'Pets & Animals',
            'Science Fiction',
            'Digital Marketing',
            'AI & Machine Learning',
            'Cryptocurrency',
            'Music',
            'Movies & TV Shows',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
