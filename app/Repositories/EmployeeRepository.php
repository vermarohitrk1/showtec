<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for employees
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\User;
//use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Log;

class EmployeeRepository {

    /**
     * The employees repository instance.
     */
    protected $employees;

    /**
     * The tag repository instance.
     */
    protected $tagrepo;

    /**
     * The user repository instance.
     */
    protected $userrepo;

    /**
     * Inject dependecies
     */
    public function __construct(User $employees, UserRepository $userrepo) {
        $this->employees = $employees;
        $this->userrepo = $userrepo;

    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @return object employees collection
     */
    public function search($id = '') {

        $employees = $this->employees->newQuery();

        // all employee fields
        $employees->selectRaw('*');

        //search: various employee columns and relationships (where first, then wherehas)
        // if (request()->filled('search_query')) {
        //     $employees->where(function ($query) {
        //         $query->Where('employee_id', '=', request('search_query'));
        //         $query->orwhere('employee_company_name', 'LIKE', '%' . request('search_query') . '%');
        //         $query->orWhere('employee_created', 'LIKE', '%' . request('search_query') . '%');
        //         $query->orWhere('employee_status', '=', request('search_query'));
        //         $query->orWhereHas('tags', function ($query) {
        //             $query->where('tag_title', 'LIKE', '%' . request('search_query') . '%');
        //         });
        //         $query->orWhereHas('category', function ($query) {
        //             $query->where('category_name', 'LIKE', '%' . request('search_query') . '%');
        //         });
        //     });
        // }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('employees', request('orderby'))) {
                $employees->orderBy(request('orderby'), request('sortorder'));
            }
            //others
            switch (request('orderby')) {
            case 'contact':
                $employees->orderBy('first_name', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $employees->orderBy('first_name', 'asc');
        }
        
        // Get the results and return them.
        return $employees->paginate(config('system.settings_system_pagination_limits'));
    }

    /**
     * Create a new employee record [API]
     * @return mixed object|bool  object or process outcome
     */
    public function create($data = []) {
        //save new user
        $employee = new $this->employees;

        /** ----------------------------------------------
         * create the employee
         * ----------------------------------------------*/
        $company_id = request('company');
        $role_id = request('role');

        // $employee->phone = request('phone');
        // $employee->website = request('website');
        // $employee->vat = request('vat');
        // $employee->street = request('street');
        // $employee->city = request('city');
        // $employee->state = request('state');
        // $employee->zip = request('zip');
        // $employee->country = request('country');


        //save
        if (!$employee->save()) {
            Log::error("record could not be saved - database error", ['process' => '[EmployeeRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
        /**_____________________________________
         * add company
         _______________________________________*/
        $company = Company::find($company_id);
        $employee->company()->attach($company);

        /** ----------------------------------------------
         * add role
         * ----------------------------------------------*/
        $role = Role::find($role_id);
        $employee->role()->attach($role);

        /** ----------------------------------------------
         * create the default user
         * ----------------------------------------------*/
        request()->merge([
            'employeeid' => $employee->employee_id,
        ]);
        $password = str_random(7);
        if (!$user = $this->userrepo->create(bcrypt($password), 'user')) {
            Log::error("default employee user could not be added - database error", ['process' => '[EmployeeRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            abort(409);
        }

        /** ----------------------------------------------
         * send welcome email
         * ----------------------------------------------*/
        if ($data['send_email'] == 'yes') {
            // $emaildata = [
            //     'password' => $password,
            // ];
            // $mail = new \App\Mail\UserWelcome($user, $emaildata);
            // $mail->build();
        }

        //return employee id
        if ($data['return'] == 'id') {
            return $employee->employee_id;
        } else {
            return $employee;
        }
    }

    /**
     * Create a new employee
     * @return mixed object|bool employee object or failed
     */
    public function signUp() {

        //save new user
        $employee = new $this->employees;

        //data
        $employee->employee_company_name = request('employee_company_name');
        $employee->employee_creatorid = 0;

        //save and return id
        if ($employee->save()) {
            return $employee;
        } else {
            Log::error("record could not be saved - database error", ['process' => '[EmployeeRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * update a record
     * @param int $id employee id
     * @return mixed int|bool employee id or failed
     */
    public function update($id) {

        //get the record
        if (!$employee = $this->employees->find($id)) {
            Log::error("employee record could not be found", ['process' => '[EmployeeRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'employee_id' => $id ?? '']);
            return false;
        }

        //general
        $employee->employee_company_name = request('employee_company_name');
        $employee->employee_phone = request('employee_phone');
        $employee->employee_website = request('employee_website');
        $employee->employee_vat = request('employee_vat');

        //billing address
        $employee->employee_billing_street = request('employee_billing_street');
        $employee->employee_billing_city = request('employee_billing_city');
        $employee->employee_billing_state = request('employee_billing_state');
        $employee->employee_billing_zip = request('employee_billing_zip');
        $employee->employee_billing_country = request('employee_billing_country');
        $employee->employee_categoryid = request('employee_categoryid');

        //shipping address
        if (config('system.settings_employees_shipping_address') == 'enabled') {
            $employee->employee_shipping_street = request('employee_shipping_street');
            $employee->employee_shipping_city = request('employee_shipping_city');
            $employee->employee_shipping_state = request('employee_shipping_state');
            $employee->employee_shipping_zip = request('employee_shipping_zip');
            $employee->employee_shipping_country = request('employee_shipping_country');
        }

        //status
        if (auth()->user()->is_team) {
            $employee->employee_status = request('employee_status');
        }

        //apply custom fields data
        $this->applyCustomFields($employee);

        //save
        if ($employee->save()) {
            return $employee->employee_id;
        } else {
            Log::error("record could not be updated - database error", ['process' => '[EmployeeRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * various feeds for ajax auto complete
     * @param string $type (company_name)
     * @param string $searchterm
     * @return object employee model object
     */
    public function autocompleteFeed($type = '', $searchterm = '') {

        //validation
        if ($type == '' || $searchterm == '') {
            return [];
        }

        //start
        $query = $this->employees->newQuery();

        //ignore system employee
        $query->where('employee_id', '>', 0);

        //feed: company names
        if ($type == 'company_name') {
            $query->selectRaw('employee_company_name AS value, employee_id AS id');
            $query->where('employee_company_name', 'LIKE', '%' . $searchterm . '%');
        }

        //return
        return $query->get();
    }

    /**
     * update a record
     * @param int $id record id
     * @return bool process outcome
     */
    public function updateLogo($id) {

        //get the user
        if (!$employee = $this->employees->find($id)) {
            return false;
        }

        //update logo
        $employee->employee_logo_folder = request('logo_directory');
        $employee->employee_logo_filename = request('logo_filename');

        //save
        if ($employee->save()) {
            return true;
        } else {
            Log::error("record could not be updated - database error", ['process' => '[EmployeeRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * update model wit custom fields data (where enabled)
     */
    public function applyCustomFields($employee) {

        //custom fields
        $fields = \App\Models\CustomField::Where('customfields_type', 'employees')->get();
        foreach ($fields as $field) {
            if ($field->customfields_status == 'enabled') {
                switch ($field->customfields_name) {
                case 'employee_custom_field_1':
                    $employee->employee_custom_field_1 = request('employee_custom_field_1');
                    break;
                case 'employee_custom_field_2':
                    $employee->employee_custom_field_2 = request('employee_custom_field_2');
                    break;
                case 'employee_custom_field_3':
                    $employee->employee_custom_field_3 = request('employee_custom_field_3');
                    break;
                case 'employee_custom_field_4':
                    $employee->employee_custom_field_4 = request('employee_custom_field_4');
                    break;
                case 'employee_custom_field_5':
                    $employee->employee_custom_field_5 = request('employee_custom_field_5');
                    break;
                case 'employee_custom_field_6':
                    $employee->employee_custom_field_6 = request('employee_custom_field_6');
                    break;
                case 'employee_custom_field_7':
                    $employee->employee_custom_field_7 = request('employee_custom_field_7');
                    break;
                case 'employee_custom_field_8':
                    $employee->employee_custom_field_8 = request('employee_custom_field_8');
                    break;
                case 'employee_custom_field_9':
                    $employee->employee_custom_field_9 = request('employee_custom_field_9');
                    break;
                case 'employee_custom_field_10':
                    $employee->employee_custom_field_10 = request('employee_custom_field_10');
                    break;
                }
            }
        }
    }

}