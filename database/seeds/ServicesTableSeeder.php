<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = ['billing', 'inquiries', 'information', 'transaction', 'licensing', 'permits', 'complaints'];

        foreach ($services as $serviceName) {
            $service = new Service();
            $service->name = $serviceName;
            $service->save();
        }
    }
}
