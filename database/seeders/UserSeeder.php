<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\School;
use App\Models\SchoolGroup;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('role', 'admin')->first();
        if(!$adminRole) {
            $adminRole = Role::create([
                'role' => 'admin',
            ]);
        }
        $schoolRole = Role::where('role', 'school')->first();
        if(!$schoolRole) {
            $schoolRole = Role::create([
                'role' => 'school',
            ]);
        }

        $admin = User::where('email', 'admin@admin.com')->where('role_id', 1)->first();
        if (!$admin) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'role_id' => $adminRole->id,
                'password' => Hash::make('Admin@12345'),
                'password_text' => Hash::make('Admin@12345')
            ]);
        }

        $schoolAdmin = User::where('email', 'school@school.com')->where('role_id', 2)->first();
        if (!$schoolAdmin) {
            $schoolAdmin = User::create([
                'name' => 'School Admin',
                'email' => 'school@school.com',
                'role_id' => $schoolRole->id,
                'password' =>  Hash::make('School@12345'),
                'password_text' => 'School@12345'
            ]);
        }

        $schoolGroup = SchoolGroup::where('name', 'Demo School Group')->first();
        if(!$schoolGroup) {
            $schoolGroup = SchoolGroup::create([
                'name' => 'Demo School Group',
                'contact_person_name' => 'School Group Admin ',
                'mobile' => '0000000000',
                'email' => 'school_group_admin@demoschoolgroup.com',
                'status' => 'activated'
            ]);
        }

        $school = School::where('name', 'Demo School')->first();
        if(!$school) {
            $school = School::create([
                'school_group_id' => $schoolGroup->id,
                'name' => "Demo School",
                'contact_person_name' => "School Admin",
                'mobile' => '0000000000',
                'email' => 'school_admin@demoschool.com',
                'current_address_line1' => 'Somewhere',
                'current_address_line2' => 'around',
                'current_location' => 'not here',
                'current_landmark' => 'near there',
                'current_city' => 'the one',
                'current_pincode' => '000000',
                'current_state' => 'some state',
                'current_country' => 'india',
                'password' => Hash::make('School@12345'),
                'status' => 'activated'
            ]);
        }

        $schoolAdmin->schools()->attach($school->id);
    }
}
