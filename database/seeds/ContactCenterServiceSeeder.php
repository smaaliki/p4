<?php

use Illuminate\Database\Seeder;
use App\ContactCenter;
use App\Service;

class ContactCenterServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ccs = [
            'Municipality Contact Center' => ['billing', 'inquiries', 'information'],
            'Department of Motor Vehicles' => ['licensing', 'permits', 'complaints'],
            'Engineering Department' => ['billing', 'information', 'licensing', 'complaints'],
            'Water and Sewage' => ['inquiries', 'transaction', 'permits'],
        ];

        # Now loop through the above array, creating a new pivot for each contact center to service
        foreach ($ccs as $name => $services) {

            # First get the book
            $cc = ContactCenter::where('name', 'like', $name)->first();

            # Now loop through each service for this CC, adding the pivot
            foreach ($services as $serviceName) {
                $service = Service::where('name', 'LIKE', $serviceName)->first();

                # Connect this service to this CC
                $cc->services()->save($service);
            }
        }
    }
}
