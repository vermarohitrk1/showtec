<div class="row" id="js-projects-modal-add-edit" data-section="{{ $page['section'] }}">
    <div class="col-lg-12">
        <!--meta data - creatd by-->
        @if(isset($page['section']) && $page['section'] == 'edit')
        <div class="modal-meta-data">
            <small><strong>{{ cleanLang(__('lang.created_by')) }}:</strong>
                {{ $project->first_name ?? runtimeUnkownUser() }} |
                {{ runtimeDate($project->project_created) }}</small>
        </div>
        @endif


        <!--SELECT TEMPLATE-->
        @if($page['section'] == 'create')
        <!-- <div class="client-selectors">
            <div class="form-group row">
                <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Template</label>
                <div class="col-sm-12 col-lg-9">
                    <select class="select2-basic form-control form-control-sm" id="project_template_selector"
                        data-allow-clear="true" name="project_template_selector">
                        <option></option>
                        @foreach($templates as $template)
                        <option value="{{ $template->project_id }}"
                            data-url="{{ url('projects/template-description?id='.$template->project_id) }}"
                            data-id="{{ $template->project_id }}" data-title="{{ $template->project_title }}"
                            data-category="{{ $template->category_id }}"
                            data-billing-rate="{{ $template->project_billing_rate }}"
                            data-billing-type="{{ $template->project_billing_type }}"
                            data-billing-estimated-hours="{{ $template->project_billing_estimated_hours }}"
                            data-billing-estimated-cost="{{ $template->project_billing_costs_estimate }}"
                            data-assigned-manage-tasks="{{ $template->assignedperm_tasks_collaborate }}"
                            data-client-task-view="{{ $template->clientperm_tasks_view }}"
                            data-client-task-collaborate="{{ $template->clientperm_tasks_collaborate }}"
                            data-client-task-create="{{ $template->clientperm_tasks_create }}"
                            data-client-view-timesheets="{{ $template->clientperm_timesheets_view }}"
                            data-client-view-expenses="{{ $template->clientperm_expenses_view }}"
                            data-custom-1="{{ $template->project_custom_field_1 }}"
                            data-custom-2="{{ $template->project_custom_field_2 }}"
                            data-custom-3="{{ $template->project_custom_field_3 }}"
                            data-custom-4="{{ $template->project_custom_field_4 }}"
                            data-custom-5="{{ $template->project_custom_field_5 }}"
                            data-custom-6="{{ $template->project_custom_field_6 }}"
                            data-custom-7="{{ $template->project_custom_field_7 }}"
                            data-custom-8="{{ $template->project_custom_field_8 }}"
                            data-custom-9="{{ $template->project_custom_field_9 }}"
                            data-custom-10="{{ $template->project_custom_field_10 }}"
                            data-title="{{ $template->project_title }}">{{ $template->project_title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> -->
        @endif
        <!--/#SELECT TEMPLATE-->


        <!--TITLE-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.project_title')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="project_title" name="project_title"
                    placeholder="" value="{{ $project->project_title ?? '' }}">
            </div>
        </div>
        <!--/#TITLE-->

        <!--TYPE-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.project_type')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="project_type" name="project_type"
                    placeholder="" value="{{ $project->project_type ?? '' }}">
            </div>
        </div>
        <!--/#TYPE-->

        <!--COUNTRY-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.country')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="country" name="country"
                    placeholder="" value="{{ $project->country ?? '' }}">
            </div>
        </div>
        <!--/#COUNTRY-->

         <!--LOCATION-->
         <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.location')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="location" name="location"
                    placeholder="" value="{{ $project->location ?? '' }}">
            </div>
        </div>
        <!--/#LOCATION-->
        
        <!--START DATE-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.start_date')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm pickadate" name="project_date_start"
                    autocomplete="off" value="{{ runtimeDatepickerDate($project->project_date_start ?? '') }}">
                <input class="mysql-date" type="hidden" name="project_date_start" id="project_date_start"
                    value="{{ $project->project_date_start ?? '' }}">
            </div>
        </div>
        <!--/#START DATE-->

        <!--DUE DATE-->
        <!-- <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.deadline')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm pickadate" name="project_date_due"
                    autocomplete="off" value="{{ runtimeDatepickerDate($project->project_date_due ?? '') }}">
                <input class="mysql-date" type="hidden" name="project_date_due" id="project_date_due"
                    value="{{ $project->project_date_due ?? '' }}">
            </div>
        </div> -->
        <!--/#DUE DATE-->

        <!-- PROJECT STATUS -->
        <div class="form-group row m-t-30">
                <label for="example-month-input"
                    class="col-sm-12 col-lg-3 col-form-label text-left required">{{ cleanLang(__('lang.status')) }}</label>
                <div class="col-sm-12 col-lg-9">
                    <select class="select2-basic form-control form-control-sm" id="project_categoryid"
                        name="status">
                        @foreach($project_status as $status)
                        <option value="{{ $status }}"
                            {{ runtimePreselected($project->status ?? '', $status) }}>{{
                                                runtimeLang($status) }}</option>
                        @endforeach
                    </select>
                </div>
        </div>
        <!-- /#PROJECT STATUS -->

        <!--CLIENT NAME-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.client_name')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <div class="col-sm-12 col-lg-9">
                    <input type="text" class="form-control form-control-sm" id="client_name" name="client_name"
                        placeholder="" value="{{ $project->client_name ?? '' }}">
                </div>
            </div>
        </div>
        <!--/#CLIENT NAME-->
        
        <!--CLIENT NUMBER-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.client_number')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <div class="col-sm-12 col-lg-9">
                    <input type="text" class="form-control form-control-sm" id="client_number" name="client_number"
                        placeholder="" value="{{ $project->client_number ?? '' }}">
                </div>
            </div>
        </div>
        <!--/#CLIENT NUMBER-->

        <!--DESCRIPTION & DETAILS-->
        <!-- <div class="spacer row">
            <div class="col-sm-8">
                <span class="title">{{ cleanLang(__('lang.description_and_details')) }}</span class="title">
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="switch  text-right">
                    <label>
                        <input type="checkbox" class="js-switch-toggle-hidden-content"
                            data-target="edit_project_description_toggle">
                        <span class="lever switch-col-light-blue"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="hidden" id="edit_project_description_toggle"> -->
<!-- 
            <textarea id="project_description" name="project_description"
                class="tinymce-textarea">{{ $project->project_description ?? '' }}</textarea> -->
<!-- 
            <div class="form-group row m-t-30">
                <label for="example-month-input"
                    class="col-sm-12 col-lg-3 col-form-label text-left required">{{ cleanLang(__('lang.category')) }}</label>
                <div class="col-sm-12 col-lg-9">
                    <select class="select2-basic form-control form-control-sm" id="project_categoryid"
                        name="project_categoryid">
                        @foreach($categories as $category)
                        <option value="{{ $category->category_id }}"
                            {{ runtimePreselected($project->project_categoryid ?? '', $category->category_id) }}>{{
                                                runtimeLang($category->category_name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div> -->


            <!--assigned team members<>-->
            @if(config('visibility.project_modal_assign_fields'))
            <!-- <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.assigned')) }}</label>
                <div class="col-sm-12 col-lg-9">
                    <select name="assigned" id="assigned"
                        class="form-control form-control-sm select2-basic select2-multiple select2-tags select2-hidden-accessible"
                        multiple="multiple" tabindex="-1" aria-hidden="true">
                        <!--array of assigned-->
                        @if(isset($page['section']) && $page['section'] == 'edit' && isset($project->assigned))
                        @foreach($project->assigned as $user)
                        @php $assigned[] = $user->id; @endphp
                        @endforeach
                        @endif
                        <!--/#array of assigned-->
                        <!--users list-->
                        @foreach(config('system.team_members') as $user)
                        <option value="{{ $user->id }}"
                            {{ runtimePreselectedInArray($user->id ?? '', $assigned ?? []) }}>{{
                            $user->full_name }}</option>
                        @endforeach
                        <!--/#users list-->
                    </select>
                </div>
            </div> -->
            @endif
            <!--/#assigned team members-->

            <!--project manager<>-->
            @if(config('visibility.project_modal_assign_fields'))
            <!-- <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.manager')) }}
                    <a class="align-middle font-14 toggle-collapse" href="#project_manager_info" role="button"><i
                            class="ti-info-alt text-themecontrast"></i></a></label>
                <div class="col-sm-12 col-lg-9">
                    <select name="manager" id="manager" class="select2-basic form-control form-control-sm"
                        data-allow-clear="true">
                        <!--array of assigned-->
                        @if(isset($page['section']) && $page['section'] == 'edit' && isset($project->managers))
                        @foreach($project->managers as $user)
                        @php $manager[] = $user->id; @endphp
                        @endforeach
                        @endif
                        <!--/#array of assigned-->
                        <!--users list-->
                        @foreach(config('system.team_members') as $user)
                        <option></option>
                        <option value="{{ $user->id }}"
                            {{ runtimePreselectedInArray($user->id ?? '', $manager ?? []) }}>{{
                                    $user->full_name }}</option>
                        @endforeach
                        <!--/#users list-->
                    </select>
                </div>
            </div> -->
            @endif

            <!--/#project manager-->
            <div class="collapse" id="project_manager_info">
                <div class="alert alert-info">{{ cleanLang(__('lang.project_manager_info')) }}</div>
            </div>

            <div class="line m-t-30"></div>

        </div>
        <!--/#DESCRIPTION & DETAILS-->


        <!--PROJECT OPTIONS-->
        <div class="spacer row">
            <div class="col-sm-8">
                <span class="title">{{ cleanLang(__('lang.additional_settings')) }}</span class="title">
            </div>
            <div class="col-sm-4 text-right">
                <div class="switch">
                    <label>
                        <input type="checkbox" class="js-switch-toggle-hidden-content"
                            data-target="edit_project_setings">
                        <span class="lever switch-col-light-blue"></span>
                    </label>
                </div>
            </div>
        </div>

     
            <!--CUSTOM FIELDS-->
            <div class="spacer row">
                <div class="col-sm-8">
                    <span class="title">{{ cleanLang(__('lang.other_details')) }}</span class="title">
                </div>
                <div class="col-sm-4 text-right">
                    <div class="switch">
                        <label>
                            <input type="checkbox" class="js-switch-toggle-hidden-content"
                                data-target="edit_project_options">
                            <span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>
                </div>
            </div>




            <!--pass source-->
            <input type="hidden" name="source" value="{{ request('source') }}">

        </div>

        <!--notes-->
        <div class="row">
            <div class="col-12">
                <div><small><strong>* {{ cleanLang(__('lang.required')) }}</strong></small></div>
            </div>
        </div>
    </div>
</div>


@if(isset($page['section']) && $page['section'] == 'edit')
<!--dynamic inline - set dynamic project progress-->
<script>
    NX.varInitialProjectProgress = "{{ $project['project_progress'] }}";
</script>
@endif