<?php

use App\Models\ActivationCode;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::create([
            'name' => 'Kishan Rank',
            'email' => 'kmrank111@gmail.com',
            'password' => bcrypt('114599@kishan'),
            'admin' => 1,
            'active' => 1
        ]);

        Profile::create([
            'user_id' => $user->id,
            'avatar' => 'uploads/avatars/admin.jpg',
            'about' => ' Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sunt, optio. Explicabo doloremque vel officiis adipisci velit, perferendis omnis. Molestiae recusandae repudiandae quaerat eum ipsa dignissimos modi animi in laborum veniam!',
            'linkedin' => 'https://www.facebook.com/',
            'github' => 'https://www.youtube.com/',
            'twitter' => 'https://www.youtube.com/',
        ]);

        $code = ActivationCode::create([
            'user_id' => $user->id,
            'code' => Str::random(128)
        ]);
    }
}
