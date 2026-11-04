<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $genres = ['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi', 'Romance'];
        foreach ($genres as $g) {
            Genre::create(['name' => $g, 'slug' => Str::slug($g)]);
        }
    }
}
