<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for tasks
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Log;

class TaskRepository {

    /**
     * The tasks repository instance.
     */
    protected $tasks;

    /**
     * Inject dependecies
     */
    public function __construct(Task $tasks) {
        $this->tasks = $tasks;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @return object task collection
     */
    public function search($id = '', $data = []) {

        $tasks = $this->tasks->newQuery();

        //default - always apply filters
        if (!isset($data['apply_filters'])) {
            $data['apply_filters'] = true;
        }

        //joins
        $tasks->leftJoin('projects', 'projects.project_id', '=', 'tasks.task_projectid');
        $tasks->leftJoin('milestones', 'milestones.milestone_id', '=', 'tasks.task_milestoneid');
        $tasks->leftJoin('users', 'users.id', '=', 'tasks.task_creatorid');
        $tasks->leftJoin('clients', 'clients.client_id', '=', 'projects.project_clientid');

        //my id
        $myid = auth()->id();

        // all client fields
        $tasks->selectRaw('*');

        //count unread notifications
        $tasks->selectRaw('(SELECT COUNT(*)
                                      FROM events_tracking
                                      LEFT JOIN events ON events.event_id = events_tracking.eventtracking_eventid
                                      WHERE eventtracking_userid = ' . auth()->id() . '
                                      AND events_tracking.eventtracking_status = "unread"
                                      AND events.event_parent_type = "task"
                                      AND events.event_parent_id = tasks.task_id
                                      AND events.event_item = "comment")
                                      AS count_unread_comments');

        //count unread notifications
        $tasks->selectRaw('(SELECT COUNT(*)
                                      FROM events_tracking
                                      LEFT JOIN events ON events.event_id = events_tracking.eventtracking_eventid
                                      WHERE eventtracking_userid = ' . auth()->id() . '
                                      AND events_tracking.eventtracking_status = "unread"
                                      AND events.event_parent_type = "task"
                                      AND events.event_parent_id = tasks.task_id
                                      AND events.event_item = "attachment")
                                      AS count_unread_attachments');

        //sum all timers for this task
        $tasks->selectRaw('(SELECT COALESCE(SUM(timer_time), 0)
                                           FROM timers WHERE timer_taskid = tasks.task_id)
                                           AS sum_all_time');

        //sum my timers for this task
        $tasks->selectRaw("(SELECT COALESCE(SUM(timer_time), 0)
                                           FROM timers WHERE timer_taskid = tasks.task_id
                                           AND timer_creatorid = $myid)
                                           AS sum_my_time");

        //sum invoiced time
        $tasks->selectRaw("(SELECT COALESCE(SUM(timer_time), 0)
                                           FROM timers WHERE timer_taskid = tasks.task_id
                                           AND timer_billing_status = 'invoiced')
                                           AS sum_invoiced_time");

        //sum not invoiced time
        $tasks->selectRaw("(SELECT COALESCE(SUM(timer_time), 0)
                                           FROM timers WHERE timer_taskid = tasks.task_id
                                           AND timer_billing_status = 'not_invoiced')
                                           AS sum_not_invoiced_time");

        //default where
        $tasks->whereRaw("1 = 1");

        //filter for active or archived (default to active) - do not use this when a task id has been specified
        if (!is_numeric($id)) {
            if (!request()->filled('filter_show_archived_tasks') && !request()->filled('filter_task_state')) {
                $tasks->where('task_active_state', 'active');
            }
        }

        //filters: id
        if (request()->filled('filter_task_id')) {
            $tasks->where('task_id', request('filter_task_id'));
        }
        if (is_numeric($id)) {
            $tasks->where('task_id', $id);
        }

        //do not show items that not yet ready (i.e exclude items in the process of being cloned that have status 'invisible')
        $tasks->where('task_visibility', 'visible');

        //by default, show only project tasks
        if (request('filter_project_type') == 'project') {
            $tasks->where('task_projectid', '>', 0);
        }

        //apply filters
        if ($data['apply_filters']) {

            //filter archived tasks
            if (request()->filled('filter_task_state') && (request('filter_task_state') == 'active' || request('filter_task_state') == 'archived')) {
                $tasks->where('task_active_state', request('filter_task_state'));
            }

            //filter clients
            if (request()->filled('filter_task_clientid')) {
                $tasks->where('task_clientid', request('filter_task_clientid'));
            }

            //filter: added date (start)
            if (request()->filled('filter_task_date_start_start')) {
                $tasks->where('task_date_start', '>=', request('filter_task_date_start_start'));
            }

            //filter: added date (end)
            if (request()->filled('filter_task_date_start_end')) {
                $tasks->where('task_date_start', '<=', request('filter_task_date_start_end'));
            }

            //filter: due date (start)
            if (request()->filled('filter_task_date_due_start')) {
                $tasks->where('task_date_due', '>=', request('filter_task_date_due_start'));
            }

            //filter: start date (end)
            if (request()->filled('filter_task_date_due_end')) {
                $tasks->where('task_date_due', '<=', request('filter_task_date_due_end'));
            }

            //filter milestone id
            if (request()->filled('filter_task_milestoneid')) {
                $tasks->where('task_milestoneid', request('filter_task_milestoneid'));
            }

            //filter: only tasks visible to the client
            if (request()->filled('filter_task_client_visibility')) {
                $tasks->where('task_client_visibility', request('filter_task_client_visibility'));
            }

            //resource filtering
            if (request()->filled('taskresource_id')) {
                $tasks->where('task_projectid', request('taskresource_id'));
            }

            //filter single task status
            if (request()->filled('filter_single_task_status')) {
                $tasks->where('task_status', request('filter_single_task_status'));
            }

            //stats: - counting
            if (isset($data['stats']) && $data['stats'] == 'count-in-progress') {
                $tasks->where('task_status', 'in_progress');
            }

            //stats: - counting
            if (isset($data['stats']) && $data['stats'] == 'count-testing') {
                $tasks->where('task_status', 'testing');
            }

            //stats: - counting
            if (isset($data['stats']) && $data['stats'] == 'count-awaiting-feedback') {
                $tasks->where('task_status', 'awaiting_feedback');
            }

            //stats: - counting
            if (isset($data['stats']) && $data['stats'] == 'count-completed') {
                $tasks->where('task_status', 'completed');
            }

            //filter: only tasks visible to the client - as per project permissions
            if (request()->filled('filter_as_per_project_permissions')) {
                $tasks->where('clientperm_tasks_view', 'yes');
            }

            //filter: project
            if (request()->filled('filter_task_projectid')) {
                $tasks->where('task_projectid', request('filter_task_projectid'));
            }

            //filter status
            if (is_array(request('filter_tasks_status')) && !empty(array_filter(request('filter_tasks_status')))) {
                $tasks->whereIn('task_status', request('filter_tasks_status'));
            }

            //filter project
            if (is_array(request('filter_task_projectid'))) {
                $tasks->whereIn('task_projectid', request('filter_task_projectid'));
            }

            //filter priority
            if (is_array(request('filter_task_priority')) && !empty(array_filter(request('filter_task_priority')))) {
                $tasks->whereIn('task_priority', request('filter_task_priority'));
            }

            //filter assigned
            if (is_array(request('filter_assigned')) && !empty(array_filter(request('filter_assigned')))) {
                $tasks->whereHas('assigned', function ($query) {
                    $query->whereIn('tasksassigned_userid', request('filter_assigned'));
                });
            }

            //filter: tags
            if (is_array(request('filter_tags')) && !empty(array_filter(request('filter_tags')))) {
                $tasks->whereHas('tags', function ($query) {
                    $query->whereIn('tag_title', request('filter_tags'));
                });
            }

            //filter my tasks (using the actions button)
            if (request()->filled('filter_my_tasks')) {
                $tasks->whereHas('assigned', function ($query) {
                    $query->whereIn('tasksassigned_userid', [auth()->id()]);
                });
            }
        }

        //search: various client columns and relationships (where first, then wherehas)
        if (request()->filled('search_query') || request()->filled('query')) {
            $tasks->where(function ($query) {
                $query->Where('task_id', '=', request('search_query'));
                $query->orWhere('task_date_start', 'LIKE', '%' . date('Y-m-d', strtotime(request('search_query'))) . '%');
                $query->orWhere('task_date_due', 'LIKE', '%' . date('Y-m-d', strtotime(request('search_query'))) . '%');
                $query->orWhere('task_title', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('task_status', '=', request('search_query'));
                $query->orWhere('task_priority', '=', request('search_query'));
                //$query->orWhereRaw("YEAR(task_date_start) = ?", [request('search_query')]); //example binding - buggy
                //$query->orWhereRaw("YEAR(task_date_due) = ?", [request('search_query')]); //example binding  - buggy
                $query->orWhereHas('tags', function ($q) {
                    $q->where('tag_title', 'LIKE', '%' . request('search_query') . '%');
                });
                $query->orWhereHas('assigned', function ($q) {
                    $q->where('first_name', '=', request('search_query'));
                    $q->where('last_name', '=', request('search_query'));
                });
            });
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('tasks', request('orderby'))) {
                $tasks->orderBy(request('orderby'), request('sortorder'));
            }
            //others
            switch (request('orderby')) {
            case 'project':
                $tasks->orderBy('project_title', request('sortorder'));
                break;
            case 'time':
                $tasks->orderBy('timers_sum', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            if (request('query_type') == 'kanban') {
                $tasks->orderBy('task_position', 'asc');
            } else {
                $tasks->orderBy('task_id', 'desc');
            }
        }

        //eager load
        $tasks->with([
            'tags',
            'timers',
            'assigned',
            'projectmanagers',
        ]);

        //count relationships
        $tasks->withCount([
            'tags',
            'comments',
            'attachments',
            'timers',
            'checklists',
        ]);

        //stats - count all
        if (isset($data['stats']) && in_array($data['stats'], [
            'count-in-progress',
            'count-testing',
            'count-awaiting-feedback',
            'count-completed',
        ])) {
            return $tasks->count();
        }

        // Get the results and return them.
        if (request('query_type') == 'kanban') {
            return $tasks->paginate(config('system.settings_system_kanban_pagination_limits'));
        } else {
            return $tasks->paginate(config('system.settings_system_pagination_limits'));
        }
    }

    /**
     * Create a new record
     * @param int $position new position of the record
     * @return mixed object|bool
     */
    public function create($position = '') {

        //validate
        if (!is_numeric($position)) {
            Log::error("validation error - invalid params", ['process' => '[TaskRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        //save new user
        $task = new $this->tasks;

        //data
        $task->task_creatorid = auth()->id();
        $task->task_projectid = request('task_projectid');
        $task->task_milestoneid = request('task_milestoneid');
        $task->task_clientid = request('task_clientid');
        $task->task_date_due = (!request()->filled('task_date_due')) ? NULL : request('task_date_due');
        $task->task_title = request('task_title');
        $task->task_description = request('task_description');
        $task->task_client_visibility = (request('task_client_visibility') == 'on') ? 'yes' : 'no';
        $task->task_billable = (request('task_billable') == 'on') ? 'yes' : 'no';
        $task->task_status = request('task_status');
        $task->task_priority = request('task_priority');
        $task->task_position = $position;

        //apply custom fields data
        $this->applyCustomFields($task);

        //save and return id
        if ($task->save()) {
            return $task->task_id;
        } else {
            Log::error("record could not be saved - database error", ['process' => '[TaskRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * update a record
     * @param int $id record id
     * @return mixed bool or id of record
     */
    public function timerStop($id) {

        //get the record
        if (!$item = $this->items->find($id)) {
            return false;
        }

        //general
        $item->item_categoryid = request('item_categoryid');
        $item->item_description = request('item_description');
        $item->item_unit = request('item_unit');
        $item->item_rate = request('item_rate');

        //save
        if ($item->save()) {
            return $item->item_id;
        } else {
            Log::error("record could not be updated - database error", ['process' => '[TaskRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * update a record
     * @param int $id record id
     * @return mixed int|bool
     */
    public function update($id) {

        //get the record
        if (!$task = $this->tasks->find($id)) {
            Log::error("record could not be found", ['process' => '[LeadAssignedRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'task_id' => $id ?? '']);
            return false;
        }

        //apply custom fields data
        $this->applyCustomFields($task);

        //save
        if ($task->save()) {
            return $task->task_id;
        } else {
            return false;
        }
    }

    /**
     * update model wit custom fields data (where enabled)
     */
    public function applyCustomFields($task) {

        //custom fields
        $fields = \App\Models\CustomField::Where('customfields_type', 'tasks')->get();
        foreach ($fields as $field) {
            if ($field->customfields_status == 'enabled') {
                switch ($field->customfields_name) {
                case 'task_custom_field_1':
                    $task->task_custom_field_1 = request('task_custom_field_1');
                    break;
                case 'task_custom_field_2':
                    $task->task_custom_field_2 = request('task_custom_field_2');
                    break;
                case 'task_custom_field_3':
                    $task->task_custom_field_3 = request('task_custom_field_3');
                    break;
                case 'task_custom_field_4':
                    $task->task_custom_field_4 = request('task_custom_field_4');
                    break;
                case 'task_custom_field_5':
                    $task->task_custom_field_5 = request('task_custom_field_5');
                    break;
                case 'task_custom_field_6':
                    $task->task_custom_field_6 = request('task_custom_field_6');
                    break;
                case 'task_custom_field_7':
                    $task->task_custom_field_7 = request('task_custom_field_7');
                    break;
                case 'task_custom_field_8':
                    $task->task_custom_field_8 = request('task_custom_field_8');
                    break;
                case 'task_custom_field_9':
                    $task->task_custom_field_9 = request('task_custom_field_9');
                    break;
                case 'task_custom_field_10':
                    $task->task_custom_field_10 = request('task_custom_field_10');
                    break;
                }
            }
        }
    }

}