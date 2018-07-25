<?php

use Illuminate\Database\Seeder;
use App\Perspective;
use App\Pillar;

class PerspectivesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perspectives = [
            ['Agent Handled', 'Customer Experience'],
            ['Self Service', 'Customer Experience'],
            ['Training', 'People'],
            ['Performance', 'People'],
            ['OSFs', 'Processes'],
            ['Facilities', 'Processes'],
            ['Technology', 'Technology'],
        ];
        $count = count($perspectives);

        # Loop through each focus area, adding them to the database
        foreach ($perspectives as $key => $perspectiveData) {
            # First, figure out the id of the pillar we want to associate with this perspective
            # Find that pillar in the pillars table
            $pillar_id = Pillar::where('name', '=', $perspectiveData[1])->pluck('id')->first();

            $perspective = new Perspective();
            $perspective->created_at = Carbon\Carbon::now()->subDays($count)->toDateTimeString();
            $perspective->updated_at = Carbon\Carbon::now()->subDays($count)->toDateTimeString();
            $perspective->name = $perspectiveData[0];
            $perspective->pillar_id = $pillar_id;
            $perspective->save();
            $count--;
        }
    }
}
