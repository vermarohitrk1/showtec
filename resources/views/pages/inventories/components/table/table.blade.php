<div class="card count-{{ @count($inventories) }}" id="inventories-table-wrapper">
    <div class="card-body">
        <div class="table-responsive list-table-wrapper">
            @if (@count($inventories) > 0)
            <table id="inventories-list-table" class="table m-t-0 m-b-0 table-hover no-wrap contact-list"
                data-page-size="10">
                <thead>
                    <tr>
                        <th class="inventories_col_name"><a href="javascript:void(0)">{{ cleanLang(__('lang.item_name')) }}</a></th>
                    
                        <th class="inventories_col_serial_number"><a href="javascript:void(0)">{{ cleanLang(__('lang.serial_number')) }}</a></th>
                    
                        <th class="inventories_col_quantity"><a href="javascript:void(0)">{{ cleanLang(__('lang.quantity_short')) }}</a></th>
                    
                        @foreach($inventory_countries as $country)
                        <th class="inventories_col_name"><a href="javascript:void(0)">{{ $country->name }}</a></th>
                        @endforeach
                    
                        <th class="inventories_col_sold"><a href="javascript:void(0)">{{ cleanLang(__('lang.sold')) }}</a></th>
                    
                        <th class="inventories_col_spoiled"><a href="javascript:void(0)">{{ cleanLang(__('lang.spoiled')) }}</a></th>
                        
                        <th class="inventories_col_condemn"><a href="javascript:void(0)">{{ cleanLang(__('lang.condemn')) }}</a></th>
                    
                        <th class="inventories_col_total"><a href="javascript:void(0)">{{ cleanLang(__('lang.total')) }}</a></th>
                    
                        <th class="inventories_col_diffrence"><a href="javascript:void(0)">{{ cleanLang(__('lang.diffrence')) }}</a></th>
                    
                        <th class="inventories_col_remark"><a href="javascript:void(0)">{{ cleanLang(__('lang.remark')) }}</a></th>
                    
                        <th class="inventories_col_freight"><a href="javascript:void(0)">{{ cleanLang(__('lang.freight')) }} (CM | KG)</a></th>
                    
                        <th class="inventories_col_schedule"><a href="javascript:void(0)">{{ cleanLang(__('lang.schedule')) }}</a></th>
                    
                        <th class="inventories_col_action"><a href="javascript:void(0)">{{ cleanLang(__('lang.action')) }}</a></th>
                    </tr>
                </thead>
                <tbody id="inventories-td-container">
                    <!--ajax content here-->
                    @include('pages.inventories.components.table.ajax')
                    <!--/ajax content here-->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            @include('misc.load-more-button')
                            <!--/load more button-->
                        </td>
                    </tr>
                </tfoot>
            </table>
            @endif @if (@count($inventories) == 0)
            <!--nothing found-->
            @include('notifications.no-results-found')
            <!--nothing found-->
            @endif
        </div>
    </div>
</div>