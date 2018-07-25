<?php

use Illuminate\Database\Seeder;
use App\Touchpoint;

class TouchpointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $touchpoints = ['Inbound Informational Calls',
            'Inbound Transactional Calls',
            'Outbound Calls',
            'Email',
            'Chat / Whatsapp',
            'SMS',
            'Social Media',
            'Informational IVR Calls',
            'Transactional IVR Calls'];

        foreach ($touchpoints as $touchpointName) {
            $touchpoint = new Touchpoint();
            $touchpoint->name = $touchpointName;
            $touchpoint->save();
        }
    }
}
