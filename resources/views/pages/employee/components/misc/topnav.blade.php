                <!-- Nav tabs -->
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <!--timeline-->
                    <li class="nav-item">
                        <a class="nav-link  tabs-menu-item {{ $page['tabmenu_timeline'] ?? '' }}"
                            href="{{ url('clients') }}/{{ $employee->id }}" role="tab">{{ cleanLang(__('lang.timeline')) }}</a>
                    </li>
                    <!--contacts-->
                    <li class="nav-item">
                        <a class="nav-link  tabs-menu-item js-dynamic-url js-ajax-ux-request {{ $page['tabmenu_contacts'] ?? '' }}"
                            data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container" id="tabs-menu-contacts"
                            data-dynamic-url="{{ url('clients') }}/{{ $employee->id }}/contacts"
                            data-url="{{ url('/contacts') }}?contactresource_type=client&contactresource_id={{ $employee->id }}&source=ext&page=1"
                            href="#clients_ajaxtab" role="tab">{{ cleanLang(__('lang.users')) }}</a>
                    </li>
                    <!--projects-->
                    <li class="nav-item">
                        <a class="nav-link tabs-menu-item js-dynamic-url js-ajax-ux-request {{ $page['tabmenu_projects'] ?? '' }}"
                            data-toggle="tab" data-loading-class="loading-tabs" id="tabs-menu-projects" data-loading-target="embed-content-container"
                            data-dynamic-url="{{ _url('clients/'.$employee->id.'/projects') }}"
                            data-url="{{ url('/projects') }}?projectresource_type=client&projectresource_id={{ $employee->id }}&source=ext&page=1"
                            href="#clients_ajaxtab" role="tab">{{ cleanLang(__('lang.projects')) }}</a>
                    </li>
                    <!--files-->
                    <li class="nav-item dropdown {{ $page['tabmenu_files'] ?? '' }}">
                        <a class="nav-link dropdown-toggle tabs-menu-item tabs-menu-item" data-toggle="dropdown"
                            id="tabs-menu-files" href="javascript:void(0)" role="button" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="hidden-xs-down">{{ cleanLang(__('lang.files')) }}</span>
                        </a>
                        <div class="dropdown-menu" x-placement="bottom-start" id="fx-client-misc-topnave-files">
                            <!--[project file]-->
                            <a class="dropdown-item js-dynamic-url  js-ajax-ux-request {{ $page['tabmenu_invoices'] ?? '' }}"
                                data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                                data-dynamic-url="{{ url('/client') }}/{{ $employee->id }}/project-files"
                                data-url="{{ url('/files') }}?fileresource_type=project&filter_file_clientid={{ $employee->id }}&source=ext&page=1"
                                href="#projects_ajaxtab" role="tab">{{ cleanLang(__('lang.project_files')) }}</a>
                            <!--[client files]-->
                            <a class="dropdown-item js-dynamic-url  js-ajax-ux-request {{ $page['tabmenu_invoices'] ?? '' }}"
                                data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                                data-dynamic-url="{{ url('/client') }}/{{ $employee->id }}/client-files"
                                data-url="{{ url('/files') }}?source=ext&page=1&fileresource_id={{ $employee->id }}&fileresource_type=client"
                                href="#projects_ajaxtab" role="tab">{{ cleanLang(__('lang.employee_files')) }}</a>
                        </div>
                    </li>
                    <!--tickets-->
                    <li class="nav-item">
                        <a class="nav-link  tabs-menu-item js-dynamic-url js-ajax-ux-request {{ $page['tabmenu_tickets'] ?? '' }}"
                            id="tabs-menu-tickets" data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                            data-dynamic-url="{{ url('clients') }}/{{ $employee->id }}/tickets"
                            data-url="{{ url('/tickets') }}?ticketresource_type=client&ticketresource_id={{ $employee->id }}&source=ext&page=1"
                            href="#clients_ajaxtab" role="tab">{{ cleanLang(__('lang.tickets')) }}</a></li>
                    <!--contracts-->
                    <li class="nav-item hidden">
                        <a class="nav-link tabs-menu-item js-dynamic-url js-ajax-ux-request {{ $page['tabmenu_projects'] ?? '' }}"
                            data-toggle="tab" data-loading-class="loading-tabs" id="tabs-menu-contracts" data-loading-target="embed-content-container"
                            data-dynamic-url="{{ url('clients') }}/{{ $employee->id }}/projects"
                            data-url="{{ url('/contracts') }}?type=client&id={{ $employee->id }}&source=ext&page=1"
                            href="#clients_ajaxtab" role="tab">{{ cleanLang(__('lang.contracts')) }}</a>
                    </li>
                    <!--billing-->
                    <li class="nav-item dropdown {{ $page['tabmenu_financial'] ?? '' }}">
                        <a class="nav-link dropdown-toggle tabs-menu-item tabs-menu-item" data-toggle="dropdown"
                            id="tabs-menu-billing" href="javascript:void(0)" role="button" aria-haspopup="true"
                            id="tabs-menu-billing" aria-expanded="false">
                            <span class="hidden-xs-down">{{ cleanLang(__('lang.financial')) }}</span>
                        </a>
                        <div class="dropdown-menu" x-placement="bottom-start" id="fx-client-misc-topnave-billing">
                            <!--[invoices]-->
                            <a class="dropdown-item js-dynamic-url  js-ajax-ux-request {{ $page['tabmenu_invoices'] ?? '' }}"
                                data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                                data-dynamic-url="{{ url('/clients') }}/{{ $employee->id }}/invoices"
                                data-url="{{ url('/invoices') }}?source=ext&page=1&invoiceresource_id={{ $employee->id }}&invoiceresource_type=client"
                                href="#projects_ajaxtab" role="tab">{{ cleanLang(__('lang.invoices')) }}</a>
                            <!--[payments]-->
                            <a class="dropdown-item js-dynamic-url  js-ajax-ux-request {{ $page['tabmenu_invoices'] ?? '' }}"
                                data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                                data-dynamic-url="{{ url('/clients') }}/{{ $employee->id }}/payments"
                                data-url="{{ url('/payments') }}?source=ext&page=1&paymentresource_id={{ $employee->id }}&paymentresource_type=client"
                                href="#projects_ajaxtab" role="tab">{{ cleanLang(__('lang.payments')) }}</a>
                            <!--[expenses]-->
                            <a class="dropdown-item js-dynamic-url  js-ajax-ux-request {{ $page['tabmenu_invoices'] ?? '' }}"
                                data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                                data-dynamic-url="{{ url('/clients') }}/{{ $employee->id }}/expenses"
                                data-url="{{ url('/expenses') }}?source=ext&page=1&expenseresource_id={{ $employee->id }}&expenseresource_type=client"
                                href="#projects_ajaxtab" role="tab">{{ cleanLang(__('lang.expenses')) }}</a>
                            <!--[estimates]-->
                            <a class="dropdown-item js-dynamic-url  js-ajax-ux-request {{ $page['tabmenu_invoices'] ?? '' }}"
                                data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                                data-dynamic-url="{{ url('/clients') }}/{{ $employee->id }}/estimates"
                                data-url="{{ url('/estimates') }}?source=ext&page=1&estimateresource_id={{ $employee->id }}&estimateresource_type=client"
                                href="#projects_ajaxtab" role="tab">{{ cleanLang(__('lang.estimates')) }}</a>
                            <!--[timesheets]-->
                            <a class="dropdown-item js-dynamic-url  js-ajax-ux-request {{ $page['tabmenu_timesheets'] ?? '' }}"
                                data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                                data-dynamic-url="{{ url('/clients') }}/{{ $employee->id }}/timesheets"
                                data-url="{{ url('/timesheets') }}?source=ext&page=1&timesheetresource_id={{ $employee->id }}&timesheetresource_type=client"
                                href="#projects_ajaxtab" role="tab">{{ cleanLang(__('lang.timesheets')) }}</a>
                        </div>
                    </li>

                    <!--notes-->
                    <li class="nav-item">
                        <a class="nav-link  tabs-menu-item js-dynamic-url js-ajax-ux-request {{ $page['tabmenu_notes'] ?? '' }}"
                            id="tabs-menu-notes" data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                            data-dynamic-url="{{ url('clients') }}/{{ $employee->id }}/notes"
                            data-url="{{ url('/notes') }}?source=ext&page=1&noteresource_type=client&noteresource_id={{ $employee->id }}"
                            href="#clients_ajaxtab" role="tab">{{ cleanLang(__('lang.notes')) }}</a>
                    </li>

                </ul>