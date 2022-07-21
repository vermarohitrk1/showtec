<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserSetting;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department = Department::create([
            'name' => 'HOD',
        ]); 


         $admin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username'=>'superadmin',
            'password' => Hash::make('123456'),
            'department_id' => $department->id,
        ]); 
         $setting = UserSetting::create([
            'user_id' => $admin->id,
            'theme' => 'default',
            'pref_language' => 'english',
            'pref_email_notifications' => 'yes',
            'pref_leftmenu_position' => 'collapsed',
            'pref_statspanel_position' => 'collapsed',
            'pref_filter_own_tasks' => 'no',
            'pref_filter_own_projects' => 'no',
            'pref_filter_show_archived_projects' => 'no',
            'pref_filter_show_archived_tasks' => 'no',
            'pref_filter_show_archived_leads' => 'no',
            'pref_filter_own_leads' => 'no',
            'pref_view_tasks_layout' => 'kanban',
            'pref_view_leads_layout' => 'kanban'
        ]); 
        $administrator_role = new Role();
		$administrator_role->slug = 'superadmin';
        $administrator_role->role_leads = 3;
        $administrator_role->role_leads_scope = 'global';
		$administrator_role->name = 'Super Admin';
		$administrator_role->save();

        $administrator_role = new Role();
		$administrator_role->slug = 'human_resource';
        $administrator_role->role_leads = 0;
        $administrator_role->role_leads_scope = 'own';
		$administrator_role->name = 'Human Resource';
		$administrator_role->save();

        $administrator_role = new Role();
		$administrator_role->slug = 'project_manager';
        $administrator_role->role_leads = 3;
        $administrator_role->role_leads_scope = 'own';
		$administrator_role->name = 'Project Manager';
		$administrator_role->save();

        $administrator_role = new Role();
		$administrator_role->slug = 'employee';
        $administrator_role->role_leads = 1;
        $administrator_role->role_leads_scope = 'own';
		$administrator_role->name = 'Employee';
		$administrator_role->save();

		$hr = new Permission();
		$hr->slug = 'human_resource';
		$hr->name = 'Human Resource';
		$hr->save();

        $lead = new Permission();
		$lead->slug = 'assign_leads';
		$lead->name = 'Assign Leads';
		$lead->save();

        $inventory = new Permission();
		$inventory->slug = 'inventory_manage';
		$inventory->name = 'Inventory Manage';
		$inventory->save();

        $superadmin_role = Role::where('slug', 'superadmin')->first();
        $superadmin_role->permissions()->attach($hr);
        $superadmin_role->permissions()->attach($lead);
        $admin->roles()->attach($superadmin_role);

    }
}
