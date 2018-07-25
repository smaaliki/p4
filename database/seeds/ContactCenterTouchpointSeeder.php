<?php

use Illuminate\Database\Seeder;
use App\ContactCenter;
use App\Touchpoint;

class ContactCenterTouchpointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ccs = [
            'Municipality Contact Center' => ['Inbound Informational Calls', 'Inbound Transactional Calls', 'Email', 'Webchat', 'Social Media', 'Informational IVR Calls'],
            'Department of Motor Vehicles' => ['Inbound Informational Calls', 'Outbound Calls', 'Email', 'Social Media'],
            'Engineering Department' => ['Inbound Informational Calls', 'Inbound Transactional Calls', 'Email', 'Informational IVR Calls'],
            'Water and Sewage' => ['Inbound Informational Calls', 'Inbound Transactional Calls', 'Outbound Calls', 'Email', 'Informational IVR Calls'],
        ];

        # Now loop through the above array, creating a new pivot for each contact center to service
        foreach ($ccs as $name => $touchpoints) {
            # First get the contact center
            $cc = ContactCenter::where('name', 'like', $name)->first();

            # Now loop through each service for this CC, adding the pivot
            foreach ($touchpoints as $touchpointName) {
                $touchpoint = Touchpoint::where('name', 'LIKE', $touchpointName)->first();

                # Connect this service to this CC
                $cc->touchpoints()->save($touchpoint);
            }
        }
    }
}
