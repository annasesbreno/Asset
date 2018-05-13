<?php

use Illuminate\Database\Seeder;
use App\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Creation of SUPER ADMIN
         $user = new User();
         $user->name = "Whesley Borbon";
         $user->email = "super@mail.com";
         $user->password = bcrypt('secret');
         $user->role = 'super_admin';
         $user->status = 'Created';

         $user->save();


        //Creation of SUB ADMIN
         $user = new User();
         $user->name = "Daniel Baaya";
         $user->email = "admin@mail.com";
         $user->password = bcrypt('secret');
         $user->role = 'sub_admin';
         $user->status = 'Created';

         $user->save();

         $user = new User();
         $user->name = "Josue Yago";
         $user->email = "admin2@mail.com";
         $user->password = bcrypt('secret');
         $user->role = 'sub_admin';
         $user->status = 'Created';

         $user->save();

        //factory(App\User::class, 5)->create(); //creates 5
        /*
        factory(App\Type::class, 5)->create(); //creates 5
        factory(App\Vendor::class, 5)->create(); //creates 5
        factory(App\Platform::class, 5)->create();
        */
    }
}
