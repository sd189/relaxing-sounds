<?php

use Illuminate\Database\Seeder;

class SongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('songs')->insert([
            'name' => 'Bird Sound 1',
            'category_id' => 1,
            'link' => 'https://www.fesliyanstudios.com/play-mp3/5632'
        ]);
        DB::table('songs')->insert([
            'name' => 'Bird Sound 2',
            'category_id' => 1,
            'link' => 'https://www.fesliyanstudios.com/play-mp3/5631'
        ]);
    }
}
