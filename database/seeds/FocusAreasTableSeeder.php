<?php

use Illuminate\Database\Seeder;
use App\FocusArea;
use App\Perspective;

class FocusAreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  //Todo: Fix the dynamic scores
        $focus_areas = [
            ['1.1','Inbound Informational Calls', 18, 'Agent Handled'],
            ['1.2','Inbound Transactional Calls', 18, 'Agent Handled'],
            ['1.3','Outbound Calls', 12, 'Agent Handled'],
            ['1.4','Email',14, 'Agent Handled'],
            ['1.5','Chat / Whatsapp', 12, 'Agent Handled'],
            ['1.6','SMS', 14, 'Agent Handled'],
            ['1.7','Social Media', 12, 'Agent Handled'],
            ['1.8','Informational IVR Calls', 50, 'Self Service'],
            ['1.9','Transactional IVR Calls', 50, 'Self Service'],
            ['2.1','Agents - Essential Skills', 24, 'Training'],
            ['2.2','Agents - Written Skills', 26, 'Training'],
            ['2.3','Agents - CRM', 10, 'Training'],
            ['2.4','Team Leaders / Supervisors', 13.33, 'Training'],
            ['2.5','OSF Staff', 13.33, 'Training'],
            ['2.6','Management', 13.33, 'Training'],
            ['2.7','Agent Performance', 50, 'Performance'],
            ['2.8','TL and Supervisor Performance', 50, 'Performance'],
            ['3.1','Quality Assurance', 12.5, 'OSFs'],
            ['3.2','Workforce Management', 12.5, 'OSFs'],
            ['3.3','Real-time WFM', 12.5, 'OSFs'],
            ['3.4','Recruitment', 12.5, 'OSFs'],
            ['3.5','Training', 12.5, 'OSFs'],
            ['3.6','Complaint Handling', 12.5, 'OSFs'],
            ['3.7','Disaster Recovery', 12.5, 'OSFs'],
            ['3.8','Motivation', 12.5, 'OSFs'],
            ['3.9','Staff Facilities', 60, 'Facilities'],
            ['3.10','Disaster Recovery / Continuity', 40, 'Facilities'],
            ['4.0','Contact Centre Technology', 100, 'Technology'],
        ];
        $count = count($focus_areas);

        # Loop through each focus area, adding them to the database
        foreach ($focus_areas as $key => $focusAreaData) {
            # Find that Perspective in the Perspectives table
            $perspective_id = Perspective::where('name', '=', $focusAreaData[3])->pluck('id')->first();

            $focusArea = new FocusArea();
            $focusArea->created_at = Carbon\Carbon::now()->subDays($count)->toDateTimeString();
            $focusArea->updated_at = Carbon\Carbon::now()->subDays($count)->toDateTimeString();
            $focusArea->fa_id = $focusAreaData[0];
            $focusArea->name = $focusAreaData[1];
            $focusArea->weight = $focusAreaData[2];
            $focusArea->perspective_id = $perspective_id;

           //$this->command->comment($focusArea->fa_id.' '.$focusArea->name);
            $focusArea->save();
            $count--;
        }
    }
}
