<?php

namespace App\Http\Controllers;

use App\project;
use Illuminate\Http\Request;
use App\Http\Responses\Projects\CreateResponse;
use App\Http\Responses\Projects\IndexResponse;
use App\Permissions\ProjectPermissions;
use App\Repositories\CategoryRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;

class Projects extends Controller
{
      /**
     * The project repository instance.
     */
    protected $projectrepo;

    /**
     * The tags repository instance.
     */
    protected $tagrepo;

    /**
     * The user repository instance.
     */
    protected $userrepo;

    /**
     * The project permission instance.
     */
    protected $projectpermissions;

    /**
     * The file repository instance.
     */
    protected $filerepo;

    /**
     * The event repository instance.
     */
    protected $eventrepo;

    /**
     * The event tracking repository instance.
     */
    protected $trackingrepo;

    
  //contruct
  public function __construct(
    ProjectRepository $projectrepo,
    ProjectPermissions $projectpermissions,
    TagRepository $tagrepo,
    UserRepository $userrepo) {

    //parent
    parent::__construct();

    //vars
    $this->projectrepo = $projectrepo;
    $this->tagrepo = $tagrepo;
    $this->userrepo = $userrepo;
    $this->projectpermissions = $projectpermissions;

    //authenticated
    $this->middleware('auth');

    $this->middleware('projectsMiddlewareIndex')->only([
        'index'
    ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryRepository $categoryrepo)
    {
        //get team projects
        $projects = $this->projectrepo->search();

        //apply some permissions
        if ($projects) {
            foreach ($projects as $project) {
                $this->applyPermissions($project);
            }
        }

        //get all categories (type: project) - for filter panel
        $categories = $categoryrepo->get('project');

        //get all tags (type: lead) - for filter panel
        $tags = $this->tagrepo->getByType('project');

        //reponse payload
        $payload = [
            'page' => $this->pageSettings('projects'),
            'projects' => $projects,
            'categories' => $categories,
            'tags' => $tags,
        ];

        
        //show the view
        return new IndexResponse($payload);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CategoryRepository $categoryrepo)
    {
       
        //new project default permissions settings
        $project = $this->defautProjectPermissions();

        //project defaults
        $project['project_billing_rate'] = 10; //config('system.settings_projects_default_hourly_rate');
        $project['project_billing_estimated_hours'] = 0;
        $project['project_billing_costs_estimate'] = 0;

        //client categories
        $categories = $categoryrepo->get('project');

        //get templates
        request()->merge([
            'filter_project_type' => 'template',
        ]);
        $templates = $this->projectrepo->search();

        //get tags
        $tags = $this->tagrepo->getByType('project');

        $project_status = array('prepration','awaiting-kickoff','in-progress','completedsystem.team_members');

        //reponse payload
        $payload = [
            'page' => $this->pageSettings('create'),
            'project' => $project,
            'project_status' => $project_status,
            'templates' => $templates,
            'categories' => $categories,
            'tags' => $tags,
            'fields' => \App\Models\CustomField::Where('customfields_type', 'projects')->where('customfields_status', 'enabled')->get(),
        ];

        //show the form
        return new CreateResponse($payload);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(project $project)
    {
        //
    }

    
    /**
     * basic page setting for this section of the app
     * @param string $section page section (optional)
     * @param array $data any other data (optional)
     * @return array
     */
    private function pageSettings($section = '', $data = []) {

        //common settings
        $page = [
            'crumbs' => [
                __('lang.projects'),
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'page' => 'projects',
            'no_results_message' => __('lang.no_results_found'),
            'mainmenu_projects' => 'active',
            'submenu_projects' => 'active',
            'sidepanel_id' => 'sidepanel-filter-projects',
            'dynamic_search_url' => url('projects/search?action=search&projectresource_id=' . request('projectresource_id') . '&projectresource_type=' . request('projectresource_type')),
            'add_button_classes' => 'add-edit-project-button',
            'load_more_button_route' => 'projects',
            'source' => 'list',
        ];

        //default modal settings (modify for sepecif sections)
        $page += [
            'add_modal_title' => __('lang.add_project'),
            'add_modal_create_url' => url('projects/create?projectresource_id=' . request('projectresource_id') . '&projectresource_type=' . request('projectresource_type')),
            'add_modal_action_url' => url('projects?projectresource_id=' . request('projectresource_id') . '&projectresource_type=' . request('projectresource_type')),
            'add_modal_action_ajax_class' => '',
            'add_modal_action_ajax_loading_target' => 'commonModalBody',
            'add_modal_action_method' => 'POST',
        ];

        //projects list page
        if ($section == 'projects') {
            $page += [
                'meta_title' => __('lang.projects'),
                'heading' => __('lang.projects'),
                'sidepanel_id' => 'sidepanel-filter-projects',
            ];
            if (request('source') == 'ext') {
                $page += [
                    'list_page_actions_size' => 'col-lg-12',
                ];
            }
            return $page;
        }

        //project page
        if ($section == 'project') {
            //adjust
            $page['page'] = 'project';

            //crumbs
            $page['crumbs'] = [
                __('lang.project'),
                '#' . $data->project_id,
            ];

            //add
            $page += [
                'crumbs_special_class' => 'main-pages-crumbs',
                'meta_title' => __('lang.projects') . ' - ' . $data->project_title,
                'heading' => $data->project_title,
                'project_id' => request()->segment(2),
                'source_for_filter_panels' => 'ext',
                'section' => 'overview',
            ];
            //ajax loading and tabs
            return $page;
        }

        //ext page settings
        if ($section == 'ext') {
            $page += [
                'list_page_actions_size' => 'col-lg-12',

            ];
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
     * pass the project through the ProjectPermissions class and apply user permissions.
     * @param object project instance of the project model object
     * @return object
     */
    private function applyPermissions($project = '') {

        //sanity - make sure this is a valid project object
        if ($project instanceof \App\Models\Project) {
            //edit permissions
            $project->permission_edit_project = $this->projectpermissions->check('edit', $project);
            //delete permissions
            $project->permission_delete_project = $this->projectpermissions->check('delete', $project);
        }
    }

    
    /**
     * array of default project users permissions.
     * @return array
     */
    private function defautProjectPermissions() {
        //default permissions
        return [
            'clientperm_tasks_view' => config('system.settings_projects_clientperm_tasks_view'),
            'clientperm_tasks_collaborate' => config('system.settings_projects_clientperm_tasks_collaborate'),
            'clientperm_tasks_create' => config('system.settings_projects_clientperm_tasks_create'),
            'clientperm_timesheets_view' => config('system.settings_projects_clientperm_timesheets_view'),
            'clientperm_projects_view' => config('system.settings_projects_clientperm_projects_view'),
            'clientperm_assigned_view' => config('system.settings_projects_clientperm_assigned_view'),
            'assignedperm_tasks_collaborate' => config('system.settings_projects_assignedperm_tasks_collaborate'),
        ];
    }
}
