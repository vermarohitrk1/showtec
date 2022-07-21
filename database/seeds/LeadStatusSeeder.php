<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\LeadStatus;
use App\Models\Category;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LeadStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lead_status = LeadStatus::create([
            'leadstatus_title' => 'New',
            'leadstatus_position' => '1',
            'leadstatus_color' => 'default',
            'leadstatus_system_default'=> 'yes'
        ]);
        $lead_status = LeadStatus::create([
            'leadstatus_title' => 'Converted',
            'leadstatus_position' => '6',
            'leadstatus_color' => 'success',
            'leadstatus_system_default'=> 'yes'
        ]); 
        $lead_status = LeadStatus::create([
            'leadstatus_title' => 'Qualified',
            'leadstatus_position' => '3',
            'leadstatus_color' => 'info',
            'leadstatus_system_default'=> 'no'
        ]);
        $lead_status = LeadStatus::create([
            'leadstatus_title' => 'Proposal Sent',
            'leadstatus_position' => '5',
            'leadstatus_color' => 'lime',
            'leadstatus_system_default'=> 'no'
        ]);
        $lead_status = LeadStatus::create([
            'leadstatus_title' => 'Contacted',
            'leadstatus_position' => '2',
            'leadstatus_color' => 'warning',
            'leadstatus_system_default'=> 'no'
        ]);
        $lead_status = LeadStatus::create([
            'leadstatus_title' => 'Disqualified',
            'leadstatus_position' => '4',
            'leadstatus_color' => 'danger',
            'leadstatus_system_default'=> 'no'
        ]);

        $category = Category::create([
            'category_name' => 'Default',
            'category_system_default' => 'yrs',
            'category_visibility'=> 'everyone',
            'category_icon' => 'sl-icon-folder',
            'category_type' => 'lead',
            'category_slug'=> '3-default'
        ]);

        $company = Company::create([
            'name' => 'Macrew',
            'address' => 'SEF 47',
            'city'=> 'Mohali',
            'country' => 'India'
        ]);
        $data = array(['name' => 'Singapore', 'short_name' => 'SG'],
        ['name' => 'Malaysia', 'short_name' => 'MY'],
        ['name' => 'Thailand', 'short_name' => 'TH'],
        ['name' => 'Cambodia', 'short_name' => 'CO'],
        ['name' => 'China', 'short_name' => 'CN'],
        ['name' => 'Myanmar', 'short_name' => 'MM']);
        $country = Country::insert($data);
   }

}