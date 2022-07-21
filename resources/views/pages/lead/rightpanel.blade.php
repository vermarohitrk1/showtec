    <!----------Assigned----------->
    <div class="x-section">
        <div class="x-title">
            <h6>{{ cleanLang(__('lang.assigned_users')) }}</h6>
        </div>
        <span id="lead-assigned-container" class="">
            @include('pages.lead.components.assigned')
        </span>
        <!--user-->
        <span class="x-assigned-user x-assign-new js-card-settings-button-static card-lead-assigned" tabindex="0"
            data-popover-content="card-lead-team" data-title="{{ cleanLang(__('lang.assign_users')) }}"><i
                class="mdi mdi-plus"></i></span>
    </div>

    <!----------settings----------->
    <div class="x-section">

        <!--customer-->
        @if($lead->lead_converted == 'yes')
        <div class="x-element x-customer">{{ cleanLang(__('lang.customer')) }}</div>
        @endif

        <div class="x-title">
            <h6>{{ cleanLang(__('lang.details')) }}</h6>
        </div>
        <!--Name-->
        <div class="x-element text-center font-14" id="card-lead-element-container-name">
            @if($lead->permission_edit_lead)
            <span class="x-highlight x-editable js-card-settings-button-static" id="card-lead-name" tabindex="0"
                data-popover-content="card-lead-name-popover" data-title="{{ cleanLang(__('lang.name')) }}">
                <span id="card-lead-firstname-containter">{{ $lead->lead_firstname }}</span> <span
                    id="card-lead-lastname-containter">{{ $lead->lead_lastname }}</span></span>
            @else
            <span class="x-highlight">{{ $lead->lead_firstname }} {{ $lead->lead_lastname }}</span>
            @endif
        </div>
        <!--value-->
        <div class="x-element"><i class="mdi mdi-cash-multiple"></i> <span>{{ cleanLang(__('lang.value')) }}: </span>
            @if($lead->permission_edit_lead)
            <span class="x-highlight x-editable js-card-settings-button-static" id="card-lead-value" tabindex="0"
                data-popover-content="card-lead-value-popover" data-value="{{ $lead->lead_value }}"
                data-title="{{ cleanLang(__('lang.value')) }}">{{ runtimeMoneyFormat($lead->lead_value) }}</span>
            @else
            <span class="x-highlight">{{ runtimeMoneyFormat($lead->lead_value) }}</span>
            @endif
        </div>
        <!--status-->
        <div class="x-element" id="card-lead-status"><i class="mdi mdi-flag"></i>
            <span>{{ cleanLang(__('lang.status')) }}: </span>
            @if($lead->permission_edit_lead)
            <span class="x-highlight x-editable js-card-settings-button-static" id="card-lead-status-text" tabindex="0"
                data-popover-content="card-lead-status-popover"
                data-title="{{ cleanLang(__('lang.status')) }}">{{ runtimeLang($lead->leadstatus_title) }}</strong></span>
            @else
            <span class="x-highlight">{{ runtimeLang($lead->leadstatus_title) }}</span>
            @endif
        </div>
        <!--added-->
        <div class="x-element" id="lead-date-added"><i class="mdi mdi-calendar-plus"></i>
            <span>{{ cleanLang(__('lang.added')) }}:</span>
            @if($lead->permission_edit_lead)
            <span class="x-highlight x-editable card-pickadate"
                data-url="{{ url('/leads/'.$lead->lead_id.'/update-date-added/') }}" data-type="form"
                data-form-id="lead-date-added" data-hidden-field="lead_created"
                data-container="lead-date-added-container" data-ajax-type="post"
                id="lead-date-added-container">{{ runtimeDate($lead->lead_created) }}</span></span>
            <input type="hidden" name="lead_created" id="lead_created">
            @else
            <span class="x-highlight">{{ runtimeDate($lead->lead_created) }}</span>
            @endif
        </div>

        <!--category-->
        <div class="x-element" id="card-lead-category"><i class="mdi mdi-folder"></i>
            <span>{{ cleanLang(__('lang.category')) }}:
            </span>
            @if($lead->permission_edit_lead)
            <span class="x-highlight x-editable js-card-settings-button-static" id="card-lead-category-text"
                tabindex="0" data-popover-content="card-lead-category-popover"
                data-title="{{ cleanLang(__('lang.status')) }}">{{ runtimeLang($lead->category_name) }}</strong></span>
            @else
            <span class="x-highlight">{{ runtimeLang($lead->category_name) }}</span>
            @endif
        </div>
        <!--last contacted-->
        <div class="x-element" id="lead-contacted"><i class="mdi mdi-message-text"></i>
            <span>{{ cleanLang(__('lang.contacted')) }}:
            </span>
            @if($lead->permission_edit_lead)
            <span class="x-highlight x-editable card-pickadate"
                data-url="{{ url('/leads/'.$lead->lead_id.'/update-contacted/') }}" data-type="form"
                data-progress-bar='hidden' data-form-id="lead-contacted" data-hidden-field="lead_last_contacted"
                data-container="lead-contacted-container" data-ajax-type="post"
                id="lead-contacted-container">{{ runtimeDate($lead->lead_last_contacted) }}</span>
            <input type="hidden" name="lead_last_contacted" id="lead_last_contacted">
            @else
            <span class="x-highlight">{{ runtimeDate($lead->lead_last_contacted) }}</span>
            @endif
        </div>
        <!--telephone-->
        <div class="x-element"><i class="mdi mdi-phone"></i> <span>{{ cleanLang(__('lang.telephone')) }}: </span>
            @if($lead->permission_edit_lead)
            <span class="x-highlight x-editable js-card-settings-button-static" id="card-lead-phone" tabindex="0"
                data-popover-content="card-lead-phone-popover" data-value="{{ $lead->lead_phone }}"
                data-title="{{ cleanLang(__('lang.telephone')) }}">{{ $lead->lead_phone ?? '---' }}</span>
            @else
            <span class="x-highlight">{{ $lead->lead_phone ?? '---' }}</span>
            @endif
        </div>

        <!--email-->
        <div class="x-element"><i class="mdi mdi-email"></i> <span>{{ cleanLang(__('lang.email')) }}: </span>
            @if($lead->permission_edit_lead)
            <span class="x-highlight x-editable js-card-settings-button-static" id="card-lead-email" tabindex="0"
                data-popover-content="card-lead-email-popover" data-value="{{ $lead->lead_email }}"
                data-title="{{ cleanLang(__('lang.email')) }}">{{ $lead->lead_email ?? '---' }}</span>
            @else
            <span class="x-highlight">{{ $lead->lead_email ?? '---' }}</span>
            @endif
        </div>

        <!--Source-->
        <div class="x-element" id="card-lead-source"><i class="mdi mdi-magnify-plus"></i>
            <span>{{ cleanLang(__('lang.source')) }}:
            </span>
            @if($lead->permission_edit_lead)
            <span class="x-highlight x-editable js-card-settings-button-static" id="card-lead-source-text" tabindex="0"
                data-popover-content="card-lead-source-popover"
                data-title="{{ cleanLang(__('lang.source')) }}">{{ $lead->lead_source ?? '---' }}</strong></span>
            @else
            <span class="x-highlight">{{ $lead->lead_source ?? '---' }}</span>
            @endif
        </div>
    </div>





    <!----------actions----------->
    <div class="x-section">
        <div class="x-title">
            <h6>{{ cleanLang(__('lang.actions')) }}</h6>
        </div>
        <!--convert to customer-->
        @if($lead->permission_edit_lead && $lead->lead_converted == 'no')
        <div class="x-element x-action js-lead-convert-to-customer" id="card-lead-milestone" tabindex="0"
            data-popover-content="card-lead-milestones" data-title="{{ cleanLang(__('lang.convert_to_customer')) }}"><i
                class="mdi mdi-redo-variant"></i>
            <span class="x-highlight">Convert To Customer</strong></span>
        </div>
        @endif

        <!--archive-->
        @if($lead->permission_edit_lead && runtimeArchivingOptions())
        <div class="x-element x-action confirm-action-info  {{ runtimeActivateOrAchive('archive-button', $lead->lead_active_state) }} card_archive_button_{{ $lead->lead_id }}"
            id="card_archive_button_{{ $lead->lead_id }}" data-confirm-title="{{ cleanLang(__('lang.archive_lead')) }}"
            data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="PUT"
            data-url="{{ url('/') }}/leads/{{ $lead->lead_id }}/archive"><i class="mdi mdi-archive"></i> <span
                class="x-highlight" id="lead-start-date">{{ cleanLang(__('lang.archive')) }}</span></span></div>
        @endif

        <!--restore-->
        @if($lead->permission_edit_lead && runtimeArchivingOptions())
        <div class="x-element x-action confirm-action-info  {{ runtimeActivateOrAchive('activate-button', $lead->lead_active_state) }} card_restore_button_{{ $lead->lead_id }}"
            id="card_restore_button_{{ $lead->lead_id }}" data-confirm-title="{{ cleanLang(__('lang.restore_lead')) }}"
            data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="PUT"
            data-url="{{ url('/') }}/leads/{{ $lead->lead_id }}/activate"><i class="mdi mdi-archive"></i> <span
                class="x-highlight" id="lead-start-date">{{ cleanLang(__('lang.restore')) }}</span></span></div>
        @endif


        <!--delete-->
        @if($lead->permission_delete_lead)
        <div class="x-element x-action confirm-action-danger"
            data-confirm-title="{{ cleanLang(__('lang.delete_item')) }}"
            data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
            data-url="{{ url('/') }}/leads/{{ $lead->lead_id }}"><i class="mdi mdi-delete"></i> <span
                class="x-highlight" id="lead-start-date">{{ cleanLang(__('lang.delete')) }}</span></span></div>
        @endif
    </div>


    <!--custom form fields-->
    <div class="x-section">
        <div class="x-title">
            <h6>{{ cleanLang(__('lang.details')) }}</h6>
        </div>
        <!--fields-->
        <div class="custom-fields-panel-edit" id="custom-fields-panel-edit">
            <div class="custom-fields-panel-content" id="custom-fields-panel-content">
                @include('pages.lead.components.custom-fields')
            </div>
            @if($fields->count() >0 && $lead->permission_edit_lead)
            <div class="text-right"><a href="#" id="custom-fields-panel-edit-button"
                    class="font-11 text-underlined">@lang('lang.edit_details')</a></div>
            @endif
        </div>

        <!--edit fields-->
        @if($lead->permission_edit_lead)
        <div class="hidden" id="custom-fields-panel">
            <div class="custom-fields-panel-edit-container" id="custom-fields-panel-edit-container">
                @include('pages.lead.components.custom-fields-edit')
            </div>
            <div class="form-group text-right">
                <button type="button" class="btn waves-effect waves-light btn-xs btn-default"
                    id="custom-fields-panel-close-button">@lang('lang.close')</button>
                <button type="button" class="btn btn-danger btn-sm ajax-request btn-xs disable-on-click"
                    data-url="{{ url('/leads/'.$lead->lead_id.'/update-custom') }}" data-type="form"
                    data-ajax-type="post" data-form-id="custom-fields-panel">
                    {{ cleanLang(__('lang.update')) }}
                </button>
            </div>
        </div>
        @endif
    </div>

    <!--organisation-->
    <div class="x-section">
        <!--address and organisation - toggle-->
        <div class="spacer row m-r-4">
            <div class="col-sm-12 col-lg-8">
                <span class="title">{{ cleanLang(__('lang.organisation')) }}</span class="title">
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="switch  text-right">
                    <label>
                        <input type="checkbox" name="show_more_settings_leads" id="card-lead-toggle-organisation"
                            class="js-switch-toggle-hidden-content" data-target="card-lead-organisation">
                        <span class="lever switch-col-light-blue"></span>
                    </label>
                </div>
            </div>
        </div>
        <!--address and organisation - toggle-->
        <!--address and organisation-->
        <div class="hidden x-form-section" id="card-lead-organisation">

            <!--company name-->
            <div class="form-group row">
                <label
                    class="col-sm-12 text-left control-label col-form-label">{{ cleanLang(__('lang.company_name')) }}</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="lead_company_name"
                        name="lead_company_name" placeholder="" value="{{ $lead->lead_company_name ?? '' }}">
                </div>
            </div>
            <!--job title-->
            <div class="form-group row">
                <label
                    class="col-sm-12 text-left control-label col-form-label">{{ cleanLang(__('lang.job_title')) }}</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="lead_job_position"
                        name="lead_job_position" placeholder="" value="{{ $lead->lead_job_position ?? '' }}">
                </div>
            </div>
            <!--street-->
            <div class="form-group row">
                <label
                    class="col-sm-12 text-left control-label col-form-label">{{ cleanLang(__('lang.street')) }}</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="lead_street" name="lead_street"
                        placeholder="" value="{{ $lead->lead_street ?? '' }}">
                </div>
            </div>
            <!--city-->
            <div class="form-group row">
                <label class="col-sm-12 text-left control-label col-form-label">{{ cleanLang(__('lang.city')) }}</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="lead_city" name="lead_city"
                        placeholder="" value="{{ $lead->lead_city ?? '' }}">
                </div>
            </div>
            <!--state-->
            <div class="form-group row">
                <label
                    class="col-sm-12 text-left control-label col-form-label">{{ cleanLang(__('lang.state')) }}</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="lead_state" name="lead_state"
                        placeholder="" value="{{ $lead->lead_state ?? '' }}">
                </div>
            </div>
            <!--zip-->
            <div class="form-group row">
                <label
                    class="col-sm-12 text-left control-label col-form-label">{{ cleanLang(__('lang.zipcode')) }}</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="lead_zip" name="lead_zip" placeholder=""
                        value="{{ $lead->lead_zip ?? '' }}">
                </div>
            </div>
            <!--country-->
            <div class="form-group row">
                <label class="col-sm-12 text-left control-label col-form-label">{{ cleanLang(__('lang.country')) }}
                    {{ $lead->lead_country }}</label>
                <div class="col-sm-12">
                    @php $selected_country = $lead->lead_country; @endphp
                    <select class="select2-basic form-control form-control-sm" id="lead_country" name="lead_country">
                        <option></option>
                        @include('misc.country-list')
                    </select>
                </div>
            </div>
            <!--website-->
            <div class="form-group row" id="card-save-organisation-loading">
                <label
                    class="col-sm-12 text-left control-label col-form-label">{{ cleanLang(__('lang.website')) }}</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="lead_website" name="lead_website"
                        placeholder="" value="{{ $lead->lead_website ?? '' }}">
                </div>
            </div>
            <div class="form-group text-right">
                <button type="button" class="btn btn-danger btn-sm ajax-request"
                    data-loading-target="card-save-organisation-loading"
                    data-url="{{ url('/leads/'.$lead->lead_id.'/update-organisation') }}" data-type="form"
                    data-ajax-type="post" data-form-id="card-lead-organisation">
                    {{ cleanLang(__('lang.update')) }}
                </button>
            </div>
        </div>
        <!--address and organisation-->
    </div>

    <!----------meta infor----------->
    <div class="x-section">
        <div class="x-title">
            <h6>{{ cleanLang(__('lang.information')) }}</h6>
        </div>
        <div class="x-element x-action">
            <table class=" table table-bordered table-sm">
                <tbody>
                    <tr>
                        <td>{{ cleanLang(__('lang.lead_id')) }}</td>
                        <td><strong>#{{ $lead->lead_id }}</strong></td>
                    </tr>
                    <tr>
                        <td>{{ cleanLang(__('lang.created_by')) }}</td>
                        <td><strong>{{ $lead->first_name }} {{ $lead->last_name }}</strong></td>
                    </tr>
                    <tr>
                        <td>{{ cleanLang(__('lang.date_created')) }}</td>
                        <td><strong>{{ runtimeDate($lead->lead_created) }}</strong></td>
                    </tr>
                    @if($lead->lead_converted == 'yes')
                    <tr>
                        <td>{{ cleanLang(__('lang.converted')) }}</td>
                        <td><strong>{{ runtimeDate($lead->lead_converted_date) }}</strong></td>
                    </tr>
                    <tr>
                        <td>{{ cleanLang(__('lang.converted_by')) }}</td>
                        <td><strong>{{ $lead->converted_by_first_name }}
                                {{ $lead->converted_by_last_name }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>{{ cleanLang(__('lang.client_id')) }}</td>
                        <td><strong><a
                                    href="{{ url('client/'.$lead->lead_converted_clientid) }}">#{{ $lead->lead_converted_clientid }}</a></strong>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>




    <!----------------------------------------------------- components-------------------------------------------------------->

    <!--lead - contact name -->
    <div class="hidden" id="card-lead-name-popover">
        <div class="form-group row m-b-10">
            <label
                class="col-sm-12 text-left control-label col-form-label">{{ cleanLang(__('lang.first_name')) }}</label>
            <div class="col-sm-12 ">
                <input type="text" class="form-control form-control-sm" id="lead_firstname" name="lead_firstname"
                    placeholder="">
            </div>
        </div>
        <div class="form-group row m-b-10">
            <label
                class="col-sm-12 text-left control-label col-form-label">{{ cleanLang(__('lang.last_name')) }}</label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="lead_lastname" name="lead_lastname"
                    placeholder="">
            </div>
        </div>
        <div class="form-group text-right">
            <button type="button" class="btn btn-danger btn-sm" id="card-leads-update-name-button"
                data-progress-bar='hidden' data-url="{{ url('/leads/'.$lead->lead_id.'/update-name') }}"
                data-type="form" data-ajax-type="post" data-form-id="popover-body">
                {{ cleanLang(__('lang.update')) }}
            </button>
        </div>
    </div>

    <!--lead - value -->
    <div class="hidden" id="card-lead-value-popover">
        <div class="form-group row m-b-10">
            <div class="col-sm-12 ">
                <input type="number" class="form-control form-control-sm" id="lead_value" name="lead_value"
                    placeholder="">
            </div>
        </div>
        <div class="form-group text-right">
            <button type="button" class="btn btn-danger btn-sm" id="card-leads-update-value-button"
                data-progress-bar='hidden' data-url="{{ url('/leads/'.$lead->lead_id.'/update-value') }}"
                data-type="form" data-ajax-type="post" data-form-id="popover-body">
                {{ cleanLang(__('lang.update')) }}
            </button>
        </div>
    </div>


    <!--lead status - popover -->
    <div class="hidden" id="card-lead-status-popover">
        <div class="form-group m-t-10">
            <select class="custom-select col-12 form-control form-control-sm" id="lead_status" name="lead_status">
                @foreach($statuses as $statuse)
                <option value="{{ $statuse->leadstatus_id }}">
                    {{ runtimeLang($statuse->leadstatus_title) }}</option>
                @endforeach
            </select>
            <input type="hidden" id="current_lead_status_text" name="current_lead_status_text" value="">
        </div>
        <div class="form-group text-right">
            <button type="button" class="btn btn-danger btn-sm" id="card-leads-update-status-button"
                data-progress-bar='hidden' data-url="{{ url('/leads/'.$lead->lead_id.'/update-status') }}"
                data-type="form" data-ajax-type="post" data-form-id="popover-body">
                {{ cleanLang(__('lang.update')) }}
            </button>
        </div>
    </div>


    <!--lead category - popover -->
    <div class="hidden" id="card-lead-category-popover">
        <div class="form-group m-t-10">
            <select class="custom-select col-12 form-control form-control-sm" id="lead_categoryid"
                name="lead_categoryid">
                @foreach($categories as $category)
                <option value="{{ $category->category_id }}">
                    {{ runtimeLang($category->category_name) }}</option>
                @endforeach
            </select>
            <input type="hidden" id="current_lead_category_text" name="current_lead_category_text" value="">
        </div>
        <div class="form-group text-right">
            <button type="button" class="btn btn-danger btn-sm" id="card-leads-update-category-button"
                data-progress-bar='hidden' data-url="{{ url('/leads/'.$lead->lead_id.'/update-category') }}"
                data-type="form" data-ajax-type="post" data-form-id="popover-body">
                {{ cleanLang(__('lang.update')) }}
            </button>
        </div>
    </div>



    <!--lead - phone -->
    <div class="hidden" id="card-lead-phone-popover">
        <div class="form-group row m-b-10">
            <div class="col-sm-12 ">
                <input type="text" class="form-control form-control-sm" id="lead_phone" name="lead_phone"
                    placeholder="">
            </div>
        </div>
        <div class="form-group text-right">
            <button type="button" class="btn btn-danger btn-sm" id="card-leads-update-phone-button"
                data-progress-bar='hidden' data-url="{{ url('/leads/'.$lead->lead_id.'/update-phone') }}"
                data-type="form" data-ajax-type="post" data-form-id="popover-body">
                {{ cleanLang(__('lang.update')) }}
            </button>
        </div>
    </div>

    <!--lead - email -->
    <div class="hidden" id="card-lead-email-popover">
        <div class="form-group row m-b-10">
            <div class="col-sm-12 ">
                <input type="text" class="form-control form-control-sm" id="lead_email" name="lead_email"
                    placeholder="">
            </div>
        </div>
        <div class="form-group text-right">
            <button type="button" class="btn btn-danger btn-sm" id="card-leads-update-email-button"
                data-progress-bar='hidden' data-url="{{ url('/leads/'.$lead->lead_id.'/update-email') }}"
                data-type="form" data-ajax-type="post" data-form-id="popover-body">
                {{ cleanLang(__('lang.update')) }}
            </button>
        </div>
    </div>

    <!--lead source - popover -->
    <div class="hidden" id="card-lead-source-popover">
        <div class="form-group m-t-10">
            @if(config('system.settings_leads_allow_new_sources') == 'yes')
            <input type="text" name="lead_source" id="lead_source" class="col-12 form-control form-control-sm"
                list="sources">
            <datalist id="sources">
                @foreach($sources as $source)
                <option value="{{ $source->leadsources_title }}">
                    @endforeach
            </datalist>
            @else
            <select class="custom-select col-12 form-control form-control-sm" id="lead_source" name="lead_source">
                @foreach($sources as $source)
                <option value="{{ $source->leadsources_title }}">
                    {{ runtimeLang($source->leadsources_title) }}</option>
                @endforeach
            </select>
            @endif

        </div>
        @if($lead->permission_edit_lead)
        <div class="form-group text-right">
            <button type="button" class="btn btn-danger btn-sm" id="card-leads-update-source-button"
                data-progress-bar='hidden' data-url="{{ url('/leads/'.$lead->lead_id.'/update-source') }}"
                data-type="form" data-ajax-type="post" data-form-id="popover-body">
                {{ cleanLang(__('lang.update')) }}
            </button>
        </div>
        @endif
    </div>


    <!--assign user-->
    <div class="hidden" id="card-lead-team">
        @foreach(config('system.team_members') as $staff)
        <div class="form-check m-b-15">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" name="assigned[{{ $staff['id'] }}]" class="custom-control-input">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description"><img
                        src="{{ getUsersAvatar($staff['avatar_directory'], $staff['avatar_filename']) }}"
                        class="img-circle avatar-xsmall"> {{ $staff['first_name'] .' '. $staff["last_name"] }}</span>
            </label>
        </div>
        @endforeach
        <div class="form-group text-right">
            <button type="button" class="btn btn-danger btn-sm" id="card-leads-update-assigned"
                data-progress-bar='hidden' data-url="{{ url('/leads/'.$lead->lead_id.'/update-assigned') }}"
                data-type="form" data-ajax-type="post" data-form-id="popover-body">
                {{ cleanLang(__('lang.update')) }}
            </button>
        </div>
    </div>