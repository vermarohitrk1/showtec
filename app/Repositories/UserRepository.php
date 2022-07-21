<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for users
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\User;
use App\Models\Company;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Log;

class UserRepository {

    /**
     * The users repository instance.
     */
    protected $users;

    /**
     * Inject dependecies
     */
    public function __construct(User $users) {
        $this->users = $users;
    }

    /**
     * get a single user from the database
     * @param int $id record id
     * @return object
     */
    public function get($id = '') {

        //new query
        $users = $this->users->newQuery();

        //validation
        if (!is_numeric($id)) {
            return false;
        }

        $users->where('id', $id);


        return $users->first();
    }

    /**
     * chec if a user exists
     * @param int $id The user id
     * @return bool
     */
    public function exists($id = '') {

        //new query
        $users = $this->users->newQuery();

        //validation
        if (!is_numeric($id)) {
            Log::error("validation error - invalid params", ['process' => '[UserRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        //check
        $users->where('id', '=', $id);
        return $users->exists();
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @return object user collection
     */
    public function search($id = '') {

        //user object
        $users = $this->users->newQuery();

        //ignore system user
        $users->where('id', '!=', Auth()->user()->id);
        $users->whereDoesntHave('roles', function($q){
            $q->where('slug', 'superadmin'); 
       });
        //filter: type
        if (request()->filled('type')) {
            $users->where('type', request('type'));
        }

        //filter: status
        if (request()->filled('status')) {
            $users->where('status', request('status'));
        }

        //filter: id
        if (request()->filled('id')) {
            $users->where('id', request('id'));
        }
        if (is_numeric($id)) {
            $users->where('id', $id);
        }

        //filter: created date (start)
        if (request()->filled('filter_date_created_start')) {
            $users->where('created', '>=', request('filter_date_created_start'));
        }

        //filter: created date (end)
        if (request()->filled('filter_date_created_end')) {
            $users->where('created', '<=', request('filter_date_created_end'));
        }

        //filters: primary or not
        if (request()->filled('filter_account_owner')) {
            $users->where('account_owner', request('filter_account_owner'));
        }

        //filters-array: name  (NB: the user id is the value received)
        if (is_array(request('filter_name')) && !empty(array_filter(request('filter_name')))) {
            $users->whereIn('id', request('filter_name'));
        }

        //filters-array: email (NB: the user id is the value received)
        if (is_array(request('filter_email')) && !empty(array_filter(request('filter_email')))) {
            $users->whereIn('id', request('filter_email'));
        }


        //search: various client columns and relationships (where first, then wherehas)
        if (request()->filled('search_query')) {
            $users->where(function ($query) {
                $query->where('first_name', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('last_name', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('email', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('phone', 'LIKE', '%' . request('search_query') . '%');
            });
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            if (Schema::hasColumn('users', request('orderby'))) {
                $users->orderBy(request('orderby'), request('sortorder'));
            }
            //others
            switch (request('orderby')) {
            case 'company_name':
                $users->orderBy('client_company_name', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $users->orderBy('first_name', 'asc');
        }

        //eager load
        $users->with([
            'roles',
            'companies',
            'department'
        ]);

        // Get the results and return them.
        return $users->paginate(config('system.settings_system_pagination_limits'));
    }

    /**
     * Update a users preferences
     * e.g. left menu position, stats panel position etc
     * @param int $id users id
     * @return bool
     */
    public function updatePreferences($id = '') {

        //validation
        if (!is_numeric($id)) {
            return false;
        }

        //get user from database
        if ($user = $this->users->find($id)) {

            //preference: left menu position
            if (in_array(request('leftmenu_position'), array('open', 'collapsed'))) {
                $user->pref_leftmenu_position = request('leftmenu_position');
            }

            //preference: stats panel position
            if (in_array(request('statspanel_position'), array('open', 'collapsed'))) {
                $user->pref_statspanel_position = request('statspanel_position');
            }

            //preference: show own tasks or all
            if (in_array(request('pref_filter_own_tasks'), array('yes', 'no'))) {
                $user->pref_filter_own_tasks = request('pref_filter_own_tasks');
            }

            //preference: show archived tasks
            if (in_array(request('pref_filter_show_archived_tasks'), array('yes', 'no'))) {
                $user->pref_filter_own_tasks = request('pref_filter_show_archived_tasks');
            }

            //preference: show own projects or all
            if (in_array(request('pref_filter_own_projects'), array('yes', 'no'))) {
                $user->pref_filter_own_projects = request('pref_filter_own_projects');
            }

            //preference: show own projects or all
            if (in_array(request('pref_filter_show_archived_projects'), array('yes', 'no'))) {
                $user->pref_filter_show_archived_projects = request('pref_filter_show_archived_projects');
            }

            //update preferences
            $user->save();

            return true;
        }
        return false;
    }

    /**
     * Create a new user
     * @param string $password bcrypted password
     * @param string $type team or client
     * @param string $returning return id|obj
     * @return bool
     */
    public function create($password = '', $returning = 'id') {

        
        $user = new $this->users;
        /** ----------------------------------------------
         * create the employee
         * ----------------------------------------------*/
        $company_id = request('employee_company');
        $role_id = request('role');
        //data
        $user->email = request('email');
        $password = request('password');
        $user->first_name = request('first_name');
        $user->last_name = request('last_name');
        $user->phone = request('phone');
        $user->creatorid = Auth()->user()->id;
        $user->type = 'employee';
        $user->designation = request('designation');
        $user->department_id = request('employee_department');

        /**
         * address
         */
        $user->address = request('street');
        $user->city = request('city');
        $user->state = request('state');
        $user->zip = request('zip');
        $user->country = request('country');

        $username = strtolower($user->first_name.$user->last_name);
        $i = 0;
        while(User::whereUsername($username)->exists())
        {
            $i++;
            $username = strtolower($user->first_name.$user->last_name . $i);
        }
        $user->username = $username;
        //password
        if ($password != '') {
            $password = bcrypt($password);
            $user->password = $password;
        }else{
            $user->password = bcrypt(str_random(7));
        }

        //dashboard access
        $user->dashboard_access = (request('dashboard_access') == 'on') ? 'yes' : 'no';

        //save
        if ($user->save()) {
            /**_____________________________________
             * add company
             _______________________________________*/
            $company = Company::find($company_id);
            $user->companies()->attach($company);
    
            /** ----------------------------------------------
             * add role
            * ----------------------------------------------*/
            $role = Role::find($role_id);
            $user->roles()->attach($role);

            if ($returning == 'id') {
                return $user->id;
            } else {
                return $user;
            }
        } else {
            Log::error("record could not be saved - database error", ['process' => '[UserRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * Create a new user via the client signup form
     * @param string $password bcrypted password
     * @param string $type team or client
     * @return bool
     */
    public function signUp($clientId = '') {

        //save new user
        $user = new $this->users;

        $company_id = 1; //request('employee_company');
        //data
        $user->email = request('email');
        $user->password = Hash::make(request('password'));
        $user->first_name = request('first_name');
        $user->last_name = request('last_name');
        $user->creatorid =0;
        $user->type = 'employee';

        $username = strtolower($user->first_name.$user->last_name);
        $i = 0;
        while(User::whereUsername($username)->exists())
        {
            $i++;
            $username = strtolower($user->first_name.$user->last_name . $i);
        }
        $user->username = $username;
        //dashbord access
        $user->dashboard_access = (request('dashboard_access') == 'on') ? 'yes' : 'no';
        //save
        if ($user->save()) {
            $role = Role::where('slug','employee')->first();
            $user->roles()->attach($role);
            return $user;
        } else {
            Log::error("record could not be saved - database error", ['process' => '[UserRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * update a user record
     * @param int $id user id
     * @return bool
     */
    public function update($id) {

        //get the user
        if (!$user = $this->users->find($id)) {
            Log::error("record could not be found", ['process' => '[UserRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'user_id' => $id ?? '']);
            return false;
        }

        //general
        $user->first_name = request('first_name');
        $user->last_name = request('last_name');
        $user->status = request('status');
        $user->department_id = request('employee_department');
        $user->designation = request('designation');
        //address
        $user->address = request('street');
        $user->city = request('city');
        $user->state = request('state');
        $user->zip = request('zip');
        $user->country = request('country');
        $user->phone = request('phone');

        //dashboard access
        $user->dashboard_access = (request('dashboard_access') == 'on') ? 'yes' : 'no';

        if($user->companies->first()->id != request('employee_company')){
            $oldCompany = Company::find($user->companies->first()->id);
            $user->companies()->detach($oldCompany);
            $company = Company::find(request('employee_company'));
            $user->companies()->attach($company);
        }
        //save changes
        if ($user->save()) {
            return true;
        } else {
            Log::error("record could not be saved - database error", ['process' => '[UserRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * autocomplete feed for user names
     * @param string $type (team|client)
     * @param string $searchterm
     * @return array
     */
    public function autocompleteNames($type = '', $searchterm = '') {

        //validation
        if ($searchterm == '') {
            return [];
        }

        //start
        $query = $this->users->newQuery();
        $query->selectRaw("CONCAT_WS(' ', first_name, last_name) AS value, id");

        //filter
        if ($type != '') {
            $query->where('type', '=', $type);
        }

        $query->whereRaw("CONCAT_WS(' ', first_name, last_name) LIKE '%$searchterm%'");

        //return
        return $query->get();
    }

    /**
     * autocomplete feed for email addresses
     * @param string $type (team|client)
     * @param string $searchterm
     * @return array
     */
    public function autocompleteEmail($type = '', $searchterm = '') {

        //validation
        if ($searchterm == '') {
            return [];
        }

        //start
        $query = $this->users->newQuery();

        $query->selectRaw("email AS value, id");

        //filter
        if ($type != '') {
            $query->where('type', '=', $type);
        }

        $query->where('email', 'like', "%$searchterm%");

        //return
        return $query->get();
    }

    /**
     * get all team members who can receive estimate emails
     * @return object
     */
    public function mailingListTeamEstimates($notification_type = '') {

        //start query
        $query = $this->users->newQuery();
        $query->where('type', '=', 'team');

        //email notification
        if ($notification_type == 'email') {
            $query->where('notifications_billing_activity', '=', 'yes_email');
        }

        //email notification
        if ($notification_type == 'app') {
            $query->whereIn('notifications_billing_activity', ['yes', 'yes_email']);
        }

        //has permissions to view estimates
        $query->whereHas('role', function ($q) {
            $q->where('role_estimates', '>=', 1);
        });

        //with roles
        $query->with([
            'role',
        ]);

        //get the users
        $users = $query->get();

        //return list
        return $users;
    }

    /**
     * get all team members who can receive invoice & payments emails
     * @return object
     */
    public function mailingListInvoices($notification_type = '') {

        //start query
        $query = $this->users->newQuery();
        $query->where('type', '=', 'team');

        //email notification
        if ($notification_type == 'email') {
            $query->where('notifications_billing_activity', '=', 'yes_email');
        }

        //email notification
        if ($notification_type == 'app') {
            $query->whereIn('notifications_billing_activity', ['yes', 'yes_email']);
        }

        //has permissions to view invoices and payments
        $query->whereHas('role', function ($q) {
            $q->where('role_invoices', '>=', 1);
        });

        //with roles
        $query->with([
            'role',
        ]);

        //get the users
        $users = $query->get();

        //return list
        return $users;
    }

    /**
     * get all team members who can receive subscription emails
     * @return object
     */
    public function mailingListSubscriptions($notification_type = '') {

        //start query
        $query = $this->users->newQuery();
        $query->where('type', '=', 'team');

        //email notification
        if ($notification_type == 'email') {
            $query->where('notifications_billing_activity', '=', 'yes_email');
        }

        //ap notification
        if ($notification_type == 'app') {
            $query->whereIn('notifications_billing_activity', ['yes', 'yes_email']);
        }

        //has permissions to view subscriptions
        $query->whereHas('role', function ($q) {
            $q->where('role_subscriptions', '>=', 1);
        });

        //with roles
        $query->with([
            'role',
        ]);

        //get the users
        $users = $query->get();

        //return list
        return $users;
    }

    /**
     * various feeds for ajax auto complete
     * @example $this->userrepo->getClientUsers(1, 'all', 'ids')
     * @param numeric $type (company_name)
     * @param string $results the result return type (ids|collection)
     * @param string $user_type return all users or just the primary user (all|owner)
     * @return array
     */
    public function getClientUsers($client_id = '', $user_type = 'all', $results = 'ids') {

        //validation
        if (!is_numeric($client_id) || !in_array($results, ['ids', 'collection']) || !in_array($user_type, ['all', 'owner'])) {
            return false;
        }

        //start
        $query = $this->users->newQuery();

        //basics
        $query->where('type', 'client');
        $query->where('clientid', $client_id);

        //primary user only
        if ($user_type == 'owner') {
            $query->where('account_owner', 'yes');
        }

        //with roles
        $query->with([
            'role',
        ]);

        //get the users
        $users = $query->get();

        //create a list of id's
        $list = [];
        foreach ($users as $user) {
            $list[] = $user->id;
        }

        //return collection
        if ($results == 'collection') {
            return $users;
        } else {
            return $list;
        }
    }

    /**
     * get all team members
     * @param string $results the result return type (ids|collection)
     * @return object
     */
    public function getTeamMembers($results = 'collection') {

        //start query
        $query = $this->users->newQuery();
        $query->where('type', '=', 'team');

        //with roles
        $query->with([
            'role',
        ]);

        //get the users
        $users = $query->get();

        //create a list of id's
        $list = [];
        foreach ($users as $user) {
            $list[] = $user->id;
        }

        //return collection
        if ($results == 'collection') {
            return $users;
        } else {
            return $list;
        }
    }

    /**
     * Get the client account owner
     * @param numeric $client_id client did
     * @return object client model object
     */
    public function getClientAccountOwner($client_id = '') {

        if (!is_numeric($client_id)) {
            Log::error("validation error - invalid params", ['process' => '[UserRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        //start
        $query = $this->users->newQuery();

        //joins
        $query->leftJoin('clients', 'clients.client_id', '=', 'users.clientid');

        $query->where('type', 'client');
        $query->where('account_owner', 'yes');
        $query->where('clientid', $client_id);

        //return client
        $users = $query->take(1)->get();

        return $users->first();

    }

    /**
     * update a record
     * @param int $id record id
     * @return mixed bool or id of record
     */
    public function updateAvatar($id) {

        //get the user
        if (!$user = $this->users->find($id)) {
            Log::error("record could not be found", ['process' => '[UserRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'user_id' => $id ?? '']);
            return false;
        }

        //update users avatar
        $user->avatar_directory = request('avatar_directory');
        $user->avatar_filename = request('avatar_filename');

        //save
        if ($user->save()) {
            return true;
        } else {
            Log::error("record could not be saved - database error", ['process' => '[userRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * get all team members
     * @param int $client_id
     * @param int $new_owner_id the user to set as new owner
     * @return object
     */
    public function updateAccountOwner($client_id = '', $new_owner_id = '') {

        //validation
        if (!is_numeric($client_id) || !is_numeric($new_owner_id)) {
            Log::error("validation error - invalid params", ['process' => '[UserRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        //reset existing account owner
        $query = $this->users->newQuery();
        $query->where('clientid', $client_id);
        $query->update(['account_owner' => 'no']);

        //set owner
        $query = $this->users->newQuery();
        $query->where('clientid', $client_id);
        $query->where('id', $new_owner_id);
        $query->update(['account_owner' => 'yes']);
    }

}