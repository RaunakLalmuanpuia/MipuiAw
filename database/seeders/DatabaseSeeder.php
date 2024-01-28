<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Action;
use App\Models\Category;
use App\Models\Quote;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

       
        $this->call(DepartmentSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ActionSeeder::class);
        $this->call(MaximumDaySeeder::class);
        $this->call(QuoteSeeder::class);

        
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password'=> Hash::make('password'),
            'mobile'=> '123123123',
            'gender' => 'Male',
            'address' => 'Venghlui',
            'district' => 'Aizawl',
            'alternate_mobile'=>'12331232',
            'active'=>true,
            'role_id' => '1'

        ]);

        \App\Models\User::factory()->create([
            'name' => 'State Nodal Officer User',
            'email' => 'stateadmin@mail.com',
            'password'=> Hash::make('password'),
            'mobile'=> '3123123121',
            'active'=>true,
            'role_id' => '2'

        ]);

        //\App\Models\User::factory(5)->create();
        \App\Models\User::factory()->create([
            'name' => 'Test Citizen1',
            'email' => 'test1@mail.com',
            'password'=> Hash::make('password'),
            'mobile'=> '123123123',
            'gender' => 'Male',
            'address' => 'Venghlui',
            'district' => 'Aizawl',
            'alternate_mobile'=>'12331232',
            'active'=>true,
            'role_id' => '5'

        ]);

        \App\Models\User::factory()->create([
            'name' => 'fish1',
            'email' => 'fish1@mail.com',
            'department_id' =>11,
            'password'=> Hash::make('password'),
            'mobile'=> '123123123',
            'gender' => 'Male',
            'address' => 'Venghlui',
            'district' => 'Aizawl',
            'alternate_mobile'=>'12331232',
            'active'=>true,
            'role_id' => '3'

        ]);

        \App\Models\HomeText::create([
            'body1' => '
            Mipui Aw hi online platform a ni a, mipuiten service pek kaihhnawih thupui eng pawhah vantlang thuneitute hnenah an lungawi lohna an thehlut theihna tur online platform a ni. Department tin hian he system ah hian role-based access an nei vek a ni. 

            Mipui Aw-a grievance thehluh dinhmun chu complainant-in registration a tih laia a pek chhuah unique registration ID hmangin a enfiah theih a ni. Mipui Aw ah hian Grievance Officer-in thutlukna a siamah mipuite an lungawi loh chuan appeal facility a pe bawk. Complainant-in resolution-a a lungawi loh chuan grievance khar hnuah feedback a pe thei ang. Rating ‘Poor’ a nih chuan appeal file theihna option chu enable a ni.
            ',
             
        ]);

        \App\Models\MonthlyCredit::create([
            'monthly_limit' => '15',
        ]);
    }
}
