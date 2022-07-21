<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for clients
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employees\EmployeeStoreValidation;
use App\Http\Responses\Employees\CommonResponse;
use App\Http\Responses\Employees\CreateResponse;
use App\Http\Responses\Employees\DestroyResponse;
use App\Http\Responses\Employees\EditLogoResponse;
use App\Http\Responses\Employees\EditResponse;
use App\Http\Responses\Employees\IndexResponse;
use App\Http\Responses\Employees\ShowDynamicResponse;
use App\Http\Responses\Employees\ShowResponse;
use App\Http\Responses\Employees\StoreResponse;
use App\Http\Responses\Employees\UpdateResponse;
use App\Repositories\AttachmentRepository;
use App\Repositories\DestroyRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserSettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use DB;
use App\Models\Role;
use App\Models\Company;

class Employees extends Controller {

    /**
     * The users repository instance.
     */
    protected $userrepo;

    /**
     * The tags repository instance.
     */
    protected $tagrepo;
        /**
     * The clients repository instance.
     */
    protected $employeerepo;

    public function __construct(UserRepository $userrepo, EmployeeRepository $employeerepo, UserSettingRepository $usersettingrepo) {

        //parent
        parent::__construct();

        //authenticated
        $this->middleware('auth');

        $this->middleware('clientsMiddlewareIndex')->only([
            'index',
            'update',
            'store',
        ]);

        // $this->middleware('clientsMiddlewareEdit')->only([
        //     'edit',
        //     'update',
        // ]);

        // $this->middleware('clientsMiddlewareCreate')->only([
        //     'create',
        //     'store',
        // ]);

        // $this->middleware('clientsMiddlewareDestroy')->only(['destroy']);

        // $this->middleware('clientsMiddlewareShow')->only(['show']);

        // //dependencies
        $this->userrepo = $userrepo;
        // $this->tagrepo = $tagrepo;
        $this->employeerepo = $employeerepo;

        $this->usersettingrepo = $usersettingrepo;
    }

    /**
     * Display a listing of clients
     * @param object CategoryRepository category repository
     * @return blade view | ajax view
     */
    public function index() {

        //get clients
        $employees = $this->userrepo->search();
        //basic page settings
        $page = $this->pageSettings('employees');

        //reponse payload
        $payload = [
            'page' => $page,
            'employees' => $employees
        ];
  
        //show views
        return new IndexResponse($payload);
    }

    /**
     * Show the form for creating a new client
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //page settings
        $page = $this->pageSettings('create');
  
        $companies = Company::all();
        $departments = DB::table('departments')->get();
        $roles = Role::all();
        //reponse payload
        $payload = [
            'page' => $page,
            'roles'=> $roles,
            'companies' => $companies,
            'departments' => $departments,
        ];

        //show the form
        return new CreateResponse($payload);
    }

    /**
     * Store a newly created client in storage.
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeStoreValidation $request) {

        //save the client first [API]
        if (!$emp_id = $this->userrepo->create([
            'return' => 'id',
        ])) {
            abort(409);
        }

        //get the client object (friendly for rendering in blade template)
        $employees = $this->employeerepo->search($emp_id);

        // add user setting
        $user_setting = $this->usersettingrepo->create($emp_id);
        //counting rows
        $rows = $this->employeerepo->search();
        $count = $rows->total();
        //reponse payload
        $payload = [
            'employees' => $employees,
            'count' => $count,
        ];

        //process reponse
        return new StoreResponse($payload);

    }

    /**
     * Returns false when all is ok
     * @return \Illuminate\Http\Response
     */
    public function customFieldValidationFailed() {

        //custom field validation
        $fields = \App\Models\CustomField::Where('customfields_type', 'clients')->get();
        $errors = '';
        foreach ($fields as $field) {
            if ($field->customfields_status == 'enabled' && $field->customfields_required == 'yes') {
                if (request($field->customfields_name) == '') {
                    $errors .= '<li>' . $field->customfields_title . ' - ' . __('lang.is_required') . '</li>';
                }
            }
        }
        //return
        if ($errors != '') {
            return $errors;
        } else {
            return false;
        }
    }

    /**
     * Display the specified client
     * @param int $id client id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        //get the client
        $employees = $this->userrepo->search($id);

        //client
        $employee = $employees->first();

        //page settings
        $page = $this->pageSettings('employee', $employee);


        //set dynamic url for use in template
        switch (request()->segment(3)) {
        case 'files':
        case 'invoices':
        case 'expenses':
        case 'payments':
        case 'timesheets':
        case 'notes':
        case 'tickets':
        case 'contacts':
        case 'projects':
            $sections = request()->segment(3);
            $section = rtrim($sections, 's');
            $page['dynamic_url'] = url($sections . '?source=ext&' . $section . 'resource_type=client&' . $section . 'resource_id=' . $client->client_id);
            break;
        default:
            $page['dynamic_url'] = url("timeline/client?request_source=client&source=ext&timelineclient_id=$id&page=1");
            break;
        }

        //reponse payload
        $payload = [
            'page' => $page,
            'employee' => $employee,
        ];

        //response
        return new ShowResponse($payload);
    }

    /**
     * Display the specified client.
     * @param int $id id of the client
     * @return \Illuminate\Http\Response
     */
    public function showDynamic($id) {

        //get the client
        $clients = $this->employeerepo->search($id);

        //client
        $client = $clients->first();

        //owner - primary contact
        $owner = \App\Models\User::Where('clientid', $id)
            ->Where('account_owner', 'yes')
            ->first();

        //page settings
        $page = $this->pageSettings('client', $client);

        //set dynamic url for use in template
        switch (request()->segment(3)) {
        case 'invoices':
        case 'expenses':
        case 'estimates':
        case 'payments':
        case 'timesheets':
        case 'notes':
        case 'tickets':
        case 'contacts':
        case 'projects':
            $sections = request()->segment(3);
            $section = rtrim($sections, 's');
            $page['dynamic_url'] = url($sections . '?source=ext&' . $section . 'resource_type=client&' . $section . 'resource_id=' . $client->client_id);
            break;
        case 'project-files':
            $sections = request()->segment(3);
            $page['dynamic_url'] = url($sections . '?source=ext&' . $section . 'fileresource_type=project&' . $section . 'filter_file_clientid=' . $client->client_id);
            break;
        case 'client-files':
            $sections = request()->segment(3);
            $page['dynamic_url'] = url($sections . '?source=ext&' . $section . 'fileresource_type=client&' . $section . 'fileresource_id=' . $client->client_id);
            break;
        default:
            $page['dynamic_url'] = url("timeline/client?request_source=client&source=ext&timelineclient_id=$id&page=1");
            break;
        }

        //get tags
        $tags_resource = $this->tagrepo->getByResource('client', $id);
        $tags_user = $this->tagrepo->getByType('client');
        $tags = $tags_resource->merge($tags_user);

        //reponse payload
        $payload = [
            'page' => $page,
            'client' => $client,
            'owner' => $owner,
            'tags' => $tags,
        ];

        //response
        return new ShowDynamicResponse($payload);
    }

    /**
     * Show the form for editing the specified client.
     * @param int $id client id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        //page settings
        $page = $this->pageSettings('edit');
        $departments = DB::table('departments')->get();
        $companies = Company::all();
        //get the client
        if (!$employee = $this->employeerepo->search($id)) {
            abort(409);
        }

        //employee
        $employee = $employee->first();

        //reponse payload
        $payload = [
            'page' => $page,
            'employee' => $employee,
            'companies' => $companies,
            'departments' => $departments,
        ];

        //response
        return new EditResponse($payload);

    }

    /**
     * Update the specified client in storage.
     * @param int $id client id
     * @return \Illuminate\Http\Response
     */
    public function update($id) {

        //validate the form
        $validator = Validator::make(request()->all(), [
            'first_name' => 'required',
            "last_name" => "required",
            "employee_company" => "required",
            "employee_department" => "required"
        ]);

        //validation errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }

            abort(409, $messages);
        }

        //update client
        if (!$this->userrepo->update($id)) {
            abort(409);
        }

        //if we are suspending the client - logout all users
        if (request('status') == 'inactive') {
             \App\Models\Session::Where('user_id', $id)->delete();
        }

        //client
        $employees = $this->userrepo->search($id);

        //reponse payload
        $payload = [
            'employees' => $employees,
        ];

        //generate a response
        return new UpdateResponse($payload);
    }

    /**
     * Remove the specified client from storage.
     * @param object DestroyRepository instance of the repository
     * @param int $id client id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRepository $destroyrepo, $id) {

        //delete client
        $destroyrepo->destroyEmployee($id);

        //reponse payload
        $payload = [
            'employee_id' => $id,
        ];
        //generate a response
        return new DestroyResponse($payload);

    }

    /**
     * Return ajax details for project
     * @return \Illuminate\Http\Response
     */
    public function profile() {

        //get client details
        $client = [
            'client_id' => random_int(1, 999),
            'description' => 'hello world',
        ];

        //set the view
        $html = view('pages/client/components/tabs/profile', compact('client'))->render();

        //[action options] replace|append|prepend
        $ajax['dom_html'][] = [
            'selector' => '#embed-content-container',
            'action' => 'replace',
            'value' => $html,
        ];

        //ajax response & view
        return response()->json($ajax);
    }

    /**
     * Show the form for editing the specified clients logo
     * @return \Illuminate\Http\Response
     */
    public function logo() {

        $id = request('id');
        //reponse payload
        $payload = [
            'user_id' => $id,
        ];

        //response
        return new EditLogoResponse($payload);
    }

    /**
     * Update the specified client logo in storage.
     * @param int $id client id
     * @return \Illuminate\Http\Response
     */
    public function updateLogo(AttachmentRepository $attachmentrepo) {

        //validate input
        $data = [
            'directory' => request('avatar_directory'),
            'filename' => request('avatar_filename'),
        ];

        //process and save to db
        if (!$attachmentrepo->processAvatar($data)) {
            abort(409);
        }

        //sanity check
            $userId = request('user_id');

        //update avatar
        if (!$this->userrepo->updateAvatar(request('user_id'))) {
            abort(409);
        }

        //reponse payload
        $payload = [
            'type' => 'upload-logo',
            'user_id' => $userId,
        ];

        //generate a response
        return new CommonResponse($payload);
    }
    /**
     * basic page setting for this section of the app
     * @param string $section page section (optional)
     * @param array $data any other data (optional)
     * @return array
     */
    private function pageSettings($section = '', $data = []) {

        //

        //common settings
        $page = [
            'crumbs' => [
                __('lang.employees'),
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'page' => 'employees',
            'no_results_message' => __('lang.no_results_found'),
            'mainmenu_hr' => 'active',
            'submenu_employees' => 'active',
            'submenu_customers' => 'active',
            'tabmenu_timeline' => 'active',
            'sidepanel_id' => 'sidepanel-filter-clients',
            'dynamic_search_url' => url('employees/search?action=search&clientresource_id=' . request('clientresource_id') . '&clientresource_type=' . request('clientresource_type')),
            'add_button_classes' => '',
            'load_more_button_route' => 'employees',
            'source' => 'list',
        ];

        //default modal settings (modify for sepecif sections)
        $page += [
            'add_modal_title' => __('lang.add_client'),
            'add_modal_create_url' => url('employees/create'),
            'add_modal_action_url' => url('employees'),
            'add_modal_action_ajax_class' => '',
            'add_modal_action_ajax_loading_target' => 'commonModalBody',
            'add_modal_action_method' => 'POST',
        ];

        //projects list page
        if ($section == 'employees') {
            $page += [
                'meta_title' => __('lang.employees'),
                'heading' => __('lang.employees'),
                'mainmenu_customers' => 'active',

            ];
            return $page;
        }

        //client page
        if ($section == 'employee') {
            //adjust
            $page['page'] = 'employee';
            //add
            $page += [
                'crumbs' => [
                    __('lang.employee'),
                ],
                'meta_title' => __('lang.employee') . ' - ' . $data->companies->first()->name,
                'heading' => __('lang.employee') . ' - ' . $data->companies->first()->name,
                'project_id' => request()->segment(2),
                'source_for_filter_panels' => 'ext',
            ];

            //ajax loading and tabs
            return $page;
        }

        //create new resource
        if ($section == 'create') {
            $page += [
                'section' => 'create',
            ];
            return $page;
        }

        //edit new resource
        if ($section == 'edit') {
            $page += [
                'section' => 'edit',
            ];
            return $page;
        }

        //return
        return $page;
    }

    /**
     * data for the stats widget
     * @return array
     */
    private function statsWidget($data = array()) {

        //default values
        $stats = [
            [
                'value' => '0',
                'title' => __('lang.projects'),
                'percentage' => '0%',
                'color' => 'bg-success',
            ],
            [
                'value' => '$0.00',
                'title' => __('lang.invoices'),
                'percentage' => '0%',
                'color' => 'bg-info',
            ],
            [
                'value' => '0',
                'title' => __('lang.users'),
                'percentage' => '0%',
                'color' => 'bg-primary',
            ],
            [
                'value' => '0',
                'title' => __('lang.active'),
                'percentage' => '0%',
                'color' => 'bg-inverse',
            ],
        ];
        //calculations - set real values
        if (!empty($data)) {
            $stats[0]['value'] = '1';
            $stats[0]['percentage'] = '10%';
            $stats[1]['value'] = '2';
            $stats[1]['percentage'] = '20%';
            $stats[2]['value'] = '3';
            $stats[2]['percentage'] = '30%';
            $stats[3]['value'] = '4';
            $stats[3]['percentage'] = '40%';
        }
        //return
        return $stats;
    }
}