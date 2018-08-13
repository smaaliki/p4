<?php

use Illuminate\Database\Seeder;
use App\ContactCenter;

class ContactCentersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        # Array of CC data to add
        $ccs = [
            ['Municipality Contact Center', '', 1, '8009091', 0],
            ['Department of Motor Vehicles', '123 Main Street', 1, '9001234567', 1],
            ['Engineering Department', '', 2, '6171234567', 1],
            ['Water and Sewage', '987 Commonwealth Avenue', 3, '7811234567', 1]
        ];
        $count = count($ccs);

        # Loop through each author, adding them to the database
        foreach ($ccs as $ccData) {
            $cc = new ContactCenter();

            $cc->created_at = Carbon\Carbon::now()->subDays($count)->toDateTimeString();
            $cc->updated_at = Carbon\Carbon::now()->subDays($count)->toDateTimeString();
            $cc->name = $ccData[0];
            $cc->street_address = $ccData[1];
            $cc->emirate = $ccData[2];
            $cc->phone_number = $ccData[3];
            $cc->crm = $ccData[4];

            $cc->save();

            $count--;
        }
    }
}
