<?php

/** --------------------------------------------------------------------------------
 * This service provider configures the applications theme
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigSystemServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        //do not run this for SETUP path
        // if (env('SETUP_STATUS') != 'COMPLETED') {
        //     //skip this provider
        //     return;
        // }

        //save system settings into config array
        // $settings = \App\Models\Settings::find(1);

        //set timezone
        // date_default_timezone_set($settings->settings_system_timezone);
        date_default_timezone_set('Asia/Singapore');
        //currency symbol position setting
        // if ($settings->settings_system_currency_position == 'left') {
        //     $settings['currency_symbol_left'] = $settings->settings_system_currency_symbol;
        //     $settings['currency_symbol_right'] = '';
        // } else {
        //     $settings['currency_symbol_right'] = $settings->settings_system_currency_symbol;
        //     $settings['currency_symbol_left'] = '';
        // }

        //lead statuses
        $settings['lead_statuses'] = [];
        foreach (\App\Models\LeadStatus::get() as $status) {
            $key = $status->leadstatus_id;
            $value = $status->leadstatus_color;
            $settings['lead_statuses'] += [
                $key => $value,
            ];
        }

        //Just a list of all payment geteways - used in dropdowns and filters
        $settings['gateways'] = [
            'Paypal',
            'Stripe',
            'Bank',
            'Cash',
        ];

        //cronjob path
       $settings['cronjob_path'] = 'php ' . __DIR__ . '/application/artisan schedule:run 1>> /dev/null 2>&1';

        //all team members
        // $settings['team_members'] =  \App\Models\User::Where('type', 'employee')->Where('status', 'active')->first();
        //javascript file versioning to avoid caching when making updates
        // $settings['versioning'] = $settings->settings_system_javascript_versioning;

        //save once to config

        //lead
        $settings['settings_leads_kanban_value'] = 'show';
        $settings['settings_leads_kanban_telephone'] = 'show';
        $settings['settings_leads_kanban_date_created'] = 'show';
        $settings['settings_leads_kanban_date_contacted'] = 'show';
        $settings['settings_leads_kanban_category'] = 'show';
        $settings['settings_leads_kanban_email'] = 'show';
        $settings['settings_leads_kanban_source'] = 'show';

        // //system
        $settings['settings_system_logo_large_name'] = 'logo.png';
        $settings['settings_system_logo_small_name'] = 'logo-small.png';
        $settings['settings_clients_registration'] = 'enabled';
        ////projects
        $settings['settings_projects_clientperm_tasks_view']='yes';
        $settings['settings_projects_clientperm_tasks_collaborate']='yes';
        $settings['settings_projects_clientperm_tasks_create']='yes';
        $settings['settings_projects_clientperm_timesheets_view']='yes';
        $settings['settings_projects_clientperm_projects_view']='yes';
        $settings['settings_projects_clientperm_assigned_view']='no';
        $settings['settings_projects_assignedperm_tasks_collaborate']='yes';

        // 
        $settings['settings_system_date_format'] = 'm-d-Y';
        $settings['settings_system_datepicker_format'] = 'mm-dd-yyyy';
        $settings['settings_files_max_size_mb'] = '500';
        $settings['settings_system_currency_symbol'] = 's$';
        $settings['settings_system_decimal_separator'] = 'fullstop';
        $settings['settings_system_thousand_separator'] = 'comma';
        $settings['settings_system_currency_position'] = 'left';
        $settings['settings_system_session_login_popup'] = 'enabled';

        config(['system' => $settings]);

        config(['system.team_members' => \App\Models\User::Where('type', 'employee')->Where('status', 'active')->get()->toArray()]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
