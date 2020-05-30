<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Setting::create([
            'site_name' => "K. M. R@NK's Blog",
            'address' => 'Shree Recidency, Rajkot',
            'contact_number' => '91 96871 10300',
            'contact_email' => 'kmrank111@gmail.com'
        ]);
    }
}
