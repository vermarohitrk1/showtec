<!-- Column -->
<div class="card">
    <!--has logo-->
    @if($employee->avatar_directory != '' && $employee->avatar_filename != '')
    <div class="card-body profile_header">
        <img src="{{ getUsersAvatar($employee->avatar_directory, $employee->avatar_filename) }}" alt="user">
    </div>
    @else
    <!--no logo -->
    <div class="card-body profile_header client logo-text">
        {{ $employee->first_name .' '.$employee->last_name }}
    </div>
    @endif
    <div class="card-body p-t-0 p-b-0">
        @if(auth()->user()->is_team)
        <div>
            <small class="text-muted">{{ cleanLang(__('lang.employee_name')) }}</small>
            <h6>{{ $employee->first_name .' '.$employee->last_name }}</h6>
            <small class="text-muted">{{ cleanLang(__('lang.telephone')) }}</small>
            <h6>{{ $employee->phone }}</h6>
           <small class="text-muted">{{ cleanLang(__('lang.category')) }}</small>
            <div class="p-b-5">
                <span class="badge badge-pill badge-primary p-t-4 p-l-12 p-r-12">{{ $employee->category_name }}</span>
            </div>
            <small class="text-muted">{{ cleanLang(__('lang.account_status')) }}</small>
            <div class="p-b-5">
                @if($employee->status == 'active')
                <span class="badge badge-pill badge-success p-t-4 p-l-12 p-r-12">{{ cleanLang(__('lang.active')) }}</span>
                @else
                <span class="badge badge-pill badge-danger p-t-4 p-l-12 p-r-12">{{ cleanLang(__('lang.suspended')) }}</span>
                @endif
            </div>

        </div>
        @endif
    </div>
    <div>
        <hr> </div>
    <div class="card-body p-t-0 p-b-0">
        <div>
            <table class="table no-border m-b-0">
                <tbody>
                    <!--invoices-->
                    <tr>
                        <td class="p-l-0 p-t-5"id="fx-client-left-panel-invoices">{{ cleanLang(__('lang.invoices')) }}</td>
                        <td class="font-medium p-r-0 p-t-5">
                            {{ runtimeMoneyFormat($employee->sum_invoices_all) }}
                            <div class="progress">
                                <div class="progress-bar bg-info  w-100 h-px-3" role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                    <!--payments-->
                    <tr>
                        <td class="p-l-0 p-t-5">{{ cleanLang(__('lang.payments')) }}</td>
                        <td class="font-medium p-r-0 p-t-5">{{ runtimeMoneyFormat($employee->sum_all_payments) }}
                            <div class="progress">
                                <div class="progress-bar bg-success w-100 h-px-3" role="progressbar"aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                    <!--completed projects-->
                    <tr>
                        <td class="p-l-0 p-t-5">{{ cleanLang(__('lang.completed_projects')) }}</td>
                        <td class="font-medium p-r-0 p-t-5">{{ $employee->count_projects_completed }}
                            <div class="progress">
                                <div class="progress-bar bg-warning  w-100 h-px-3" role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                    <!--open projects-->
                    <tr>
                        <td class="p-l-0 p-t-5">{{ cleanLang(__('lang.open_projects')) }}</td>
                        <td class="font-medium p-r-0 p-t-5">{{ $employee->count_projects_pending }}
                            <div class="progress">
                                <div class="progress-bar bg-danger w-100 h-px-3" role="progressbar"aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <hr> </div>
        <!--client address-->
    <div class="card-body p-t-0 p-b-0">
        <small class="text-muted">{{ cleanLang(__('lang.address')) }}</small>
        @if($employee->billing_street !== '')
        <h6>{{ $employee->billing_street }}</h6>
        @endif
        @if($employee->billing_city !== '')
        <h6>{{ $employee->billing_city }}</h6>
        @endif
        @if($employee->billing_state !== '')
        <h6>{{ $employee->billing_state }}</h6>
        @endif
        @if($employee->billing_zip !== '')
        <h6>{{ $employee->billing_zip }}</h6>
        @endif
        @if($employee->billing_country !== '')
        <h6>{{ $employee->billing_country }}</h6>
        @endif
    </div>


    <div class="d-none last-line">
        <hr> </div>
</div>
<!-- Column -->