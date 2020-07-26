<?php

use App\Models\Admin;
use App\Models\AdminActivationCode;
use App\Models\AdminProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
            'name' => 'Kishan Rank',
            'email' => 'kmrank181@gmail.com',
            'password' => bcrypt('password'),
            'active' => 1
        ]);

        AdminProfile::create([
            'admin_id' => $admin->id,
            'avatar' => 'uploads/avatars/admin.jpg',
            'about' => ' Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sunt, optio. Explicabo doloremque vel officiis adipisci velit, perferendis omnis. Molestiae recusandae repudiandae quaerat eum ipsa dignissimos modi animi in laborum veniam!',
            'linkedin' => 'https://www.facebook.com/',
            'github' => 'https://www.youtube.com/',
            'twitter' => 'https://www.youtube.com/',
        ]);

        AdminActivationCode::create([
            'admin_id' => $admin->id,
            'code' => Str::random(128)
        ]);
    }
}
