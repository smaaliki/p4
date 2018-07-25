<?php

use Illuminate\Database\Seeder;
use App\Pillar;

class PillarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pillars = [
            ['Customer Experience', 'CE'],
            ['People', 'People'],
            ['Processes', 'Processes'],
            ['Technology', 'Tech'],
        ];
        $count = count($pillars);

        foreach ($pillars as $pillarData) {
            $pillar = new Pillar();
            $pillar->created_at = Carbon\Carbon::now()->subDays($count)->toDateTimeString();
            $pillar->updated_at = Carbon\Carbon::now()->subDays($count)->toDateTimeString();
            $pillar->name = $pillarData[0];
            $pillar->abbreviation = $pillarData[1];
            $pillar->save();
            $count--;
        }
    }
}
