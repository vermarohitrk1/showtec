@foreach($employees as $employee)
<!--each row-->
<tr id="employee_{{ $employee->id }}">
@if(config('visibility.action_column'))
    <td class="clients_col_action actions_column" id="clients_col_action_{{ $employee->id }}">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            <!--delete-->
            @if(config('visibility.action_buttons_delete'))
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}" class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_client')) }}" data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}"
                data-ajax-type="DELETE" data-url="{{ url('/employees/'.$employee->id) }}">
                <i class="sl-icon-trash"></i>
            </button>
            @endif
            <!--edit-->
            @if(config('visibility.action_buttons_edit'))
            <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/employees/'.$employee->id.'/edit') }}"
                data-loading-target="commonModalBody" data-modal-title="{{ cleanLang(__('lang.edit_employees')) }}"
                data-action-url="{{ urlResource('/employees/'.$employee->id.'?ref=list') }}" data-action-method="PUT"
                data-action-ajax-loading-target="clients-td-container">
                <i class="sl-icon-note"></i>
            </button>
            @endif
            <a href="/employees/{{ $employee->id ?? '' }}" class="btn btn-outline-info btn-circle btn-sm">
                <i class="ti-new-window"></i>
            </a>
        </span>
        <!--action button-->
        <!--more button (hidden)-->
        <span class="list-table-action dropdown hidden font-size-inherit">
            <button type="button" id="listTableAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                class="btn btn-outline-default-light btn-circle btn-sm">
                <i class="ti-more"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="listTableAction">
                <a class="dropdown-item" href="javascript:void(0)">
                    <i class="ti-new-window"></i> {{ cleanLang(__('lang.view_details')) }}</a>
            </div>
        </span>
        <!--more button-->
    </td>
    @endif

    <td class="clients_col_account_owner" id="clients_col_account_owner_{{ $employee->id }}">
        <img src="{{ getUsersAvatar($employee->avatar_directory, $employee->avatar_filename) }}" alt="user"
            class="img-circle avatar-xsmall">
        <span>{{ $employee->first_name .' '.$employee->last_name ?? '---' }}</span><br>
        <span>ID: {{ $employee->username}}</span><br>
        <span>Shift: {{ $employee->username}}</span><br>
        <a href="#">Download Profile <i class="fa fa-arrow-circle-right"></i></a>
    </td>
    <td class="clients_col_company" id="clients_col_id_{{ $employee->id }}">
        <span><strong>{{ $employee->companies->first()->name ?? '---' }}</strong></span><br>
        <span>{{ cleanLang(__('location'))}}: {{ $employee->companies->first()->address ?? '---' }}</span><br>
        <span>{{ cleanLang(__('department'))}}: {{ $employee->department->name ?? '---' }}</span><br>
        <span>{{ cleanLang(__('designation'))}}: {{ $employee->designation ?? '---' }}</span>
    </td>
    <td class="clients_col_account_owner" id="clients_col_account_owner_{{ $employee->id }}">
        <span><i class="fa fa-user"></i> {{ $employee->username}}</span><br>
        <span><i class="fa fa-envelope"></i> {{ $employee->email}}</span><br>
        <span><i class="fa fa-phone"></i> {{ $employee->phone}}</span>
    </td>
    <td class="clients_col_invoices" id="clients_col_invoices_{{ $employee->id }}">
    <span class="label label-outline-default">---</span>
    </td>
    <td class="clients_col_invoices" id="clients_col_invoices_{{ $employee->id }}">
        <span>{{ \App\Models\User::roleName($employee->id) ?? '---' }}</span><br>
    <span class="label label-success">Active</span>
    </td>

</tr>
@endforeach
<!--each row-->