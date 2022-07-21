<!--CRUMBS CONTAINER (RIGHT)-->
<div class="col-md-12  col-lg-6 align-self-center text-right parent-page-actions p-b-9"
        id="list-page-actions-container">
        <div id="list-page-actions">
                <!--edit (nb: the second condition is needed for timeline [right actions nav] replacement-->
                @if(auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('human_resource'))
                <span class="dropdown">
                        <button type="button" data-toggle="dropdown" title="{{ cleanLang(__('lang.edit')) }}" aria-haspopup="true"
                                aria-expanded="false"
                                class="data-toggle-tooltip list-actions-button btn btn-page-actions waves-effect waves-dark">
                                <i class="sl-icon-note"></i>
                        </button>

                        <div class="dropdown-menu" aria-labelledby="listTableAction">
                                <a class="dropdown-item edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                                        href="javascript:void(0)" data-toggle="modal" data-target="#commonModal"
                                        data-url="{{ urlResource('/employees/'.$employee->id.'/edit') }}"
                                        data-loading-target="commonModalBody"
                                        data-modal-title="{{ cleanLang(__('lang.edit_employee')) }}"
                                        data-action-url="{{ urlResource('/employees/'.$employee->id.'?ref=page') }}"
                                        data-action-method="PUT"
                                        data-action-ajax-loading-target="clients-td-container">
                                        {{ cleanLang(__('lang.edit_employee')) }}</a>
                                <!--upload logo-->
                                <a class="dropdown-item edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                                        href="javascript:void(0)" data-toggle="modal" data-target="#commonModal"
                                        data-url="{{ url('/employees/logo?source=page&id='.$employee->id) }}"
                                        data-loading-target="commonModalBody" data-modal-size="modal-sm"
                                        data-modal-title="{{ cleanLang(__('lang.update_avatar')) }}" data-header-visibility="hidden"
                                        data-header-extra-close-icon="visible"
                                        data-action-url="{{ url('/employees/logo?source=page&id='.$employee->id) }}"
                                        data-action-method="PUT">
                                        {{ cleanLang(__('lang.change_logo')) }}</a>
                        </div>
                </span>
                @endif

                @if(auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('human_resource'))
                <!--delete-->
                <button type="button" data-toggle="tooltip" title="{{ cleanLang(__('lang.delete_employee')) }}"
                        class="list-actions-button btn btn-page-actions waves-effect waves-dark confirm-action-danger"
                        data-confirm-title="{{ cleanLang(__('lang.delete_item')) }}" data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}"
                        data-ajax-type="DELETE" data-url="{{ url('/employees/'.$employee->id) }}"><i
                                class="sl-icon-trash"></i></button>
                @endif
        </div>
</div>