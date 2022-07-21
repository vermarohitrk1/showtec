<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [index] precheck processes for projects
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Inventory;

use App\Models\Inventory;
use Closure;
use Log;

class Index {

    /**
     * This middleware does the following
     *   2. checks users permissions to [view] projects
     *   3. modifies the request object as needed
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //various frontend and visibility settings
        $this->fronteEnd();

        //admin user permission
        if (auth()->user()->hasRole('superadmin') || auth()->user()->roleHasPermission('inventory_manage')) {
            $this->toggleOwnFilter();

            return $next($request);
        }
        //permission denied
        Log::error("permission denied", ['process' => '[permissions][inventories][index]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }

    /*
     * various frontend and visibility settings
     */
    private function fronteEnd() {


        //permissions -viewing
        if (auth()->user()->hasRole('superadmin') || auth()->user()->roleHasPermission('inventory_manage')) {
            if (auth()->user()->is_team) {
                config([
                    //visibility
                    'visibility.list_page_actions_filter_button' => true,
                    'visibility.list_page_actions_search' => true,
                    'visibility.stats_toggle_button' => true,
                    'visibility.list_page_actions_add_category' => true,
                ]);
            }
        }

        //permissions -adding
        if (auth()->user()->hasRole('superadmin') || auth()->user()->roleHasPermission('inventory_manage')) {            
            config([
                //visibility
                'visibility.list_page_actions_add_button' => true,
                'visibility.action_buttons_edit' => true,
                'visibility.projects_col_checkboxes' => true,
            ]);
        }

        //permissions -deleting
        if (auth()->user()->hasRole('superadmin') || auth()->user()->roleHasPermission('inventory_manage')) {            
            config([
                //visibility
                'visibility.action_buttons_delete' => true,
            ]);
        }


            if (auth()->user()->hasRole('superadmin')) {
                config([
                    'visibility.filter_panel_assigned' => true,
                ]);
            }

    }

    function toggleOwnFilter() {

        //visibility of 'my leads" button - only users with globa scope need this button
        if (auth()->user()->hasRole('superadmin')) {
            config([
                //visibility
                'visibility.own_projects_toggle_button' => true,
            ]);
        }



    }
}
