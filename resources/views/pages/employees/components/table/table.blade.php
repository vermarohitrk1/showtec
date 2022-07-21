<div class="card count-{{ @count($employees) }}" id="clients-table-wrapper">
    <div class="card-body">
        <div class="table-responsive list-table-wrapper">
            @if (@count($employees) > 0)
            <table id="clients-list-table" class="table m-t-0 m-b-0 table-hover no-wrap contact-list"
                data-page-size="10">
                <thead>
                    <tr>
                        
                    @if(config('visibility.action_column'))
                        <th class="clients_col_id">
                            <a class="js-ajax-ux-request js-list-sorting" href="javascript:void(0)"
                                >{{ cleanLang(__('lang.action')) }}<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                    @endif
                        <th class="clients_col_account_owner">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_contact" href="javascript:void(0)"
                                data-url="{{ urlResource('/clients?action=sort&orderby=contact&sortorder=asc') }}">{{ cleanLang(__('lang.name')) }}<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <th class="clients_col_company">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_client_company_name"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/clients?action=sort&orderby=client_company_name&sortorder=asc') }}">{{ cleanLang(__('lang.company_name')) }}<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        
                        <th class="clients_col_projects">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_count_projects"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/clients?action=sort&orderby=count_projects&sortorder=asc') }}">{{ cleanLang(__('lang.contact')) }}<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                        <th class="clients_col_invoices">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_sum_invoices"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/clients?action=sort&orderby=sum_invoices&sortorder=asc') }}">{{ cleanLang(__('lang.reports_to')) }}<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                        <th class="clients_col_tags"><a href="javascript:void(0)">{{ cleanLang(__('lang.role')) }}</a></th>
                    </tr>
                </thead>
                <tbody id="clients-td-container">
                    <!--ajax content here-->
                    @include('pages.employees.components.table.ajax')
                    <!--ajax content here-->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            @include('misc.load-more-button')
                            <!--load more button-->
                        </td>
                    </tr>
                </tfoot>
            </table>
            @endif @if (@count($employees) == 0)
            <!--nothing found-->
            @include('notifications.no-results-found')
            <!--nothing found-->
            @endif
        </div>
    </div>
</div>