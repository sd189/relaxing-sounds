<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Bird Sounds',
            'slug' => 'bird-sounds',
            'image' => 'https://images.pexels.com/photos/416179/pexels-photo-416179.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500'
        ]);
        DB::table('categories')->insert([
            'name' => 'Piano Sounds',
            'slug' => 'piano-sounds',
            'image' => 'https://www.thepiano.sg/sites/thepiano.sg/files/styles/read_article_main_picture/public/thepiano_images/read/2015/12/09/16/22/piano-keys.jpg?itok=4uyk29It'
        ]);
        DB::table('categories')->insert([
            'name' => 'Nature Sounds',
            'slug' => 'nature-sounds',
            'image' => 'https://images.pexels.com/photos/257360/pexels-photo-257360.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500'
        ]);
    }
}
