@foreach($inventories as $inventory)
<tr id="inventories_{{ $inventory->id }}" class="{{ $inventory->highlighted ? 'table-warning' : 'table-light'}}">
    <td class="inventories_col_name">
        {{ $inventory->name }}
    </td>
    
    <td class="inventories_col_serial_number">
        {{ $inventory->serial_number }}
    </td>

    <td class="inventories_col_quantity">
        {{ $inventory->quantity }}
    </td>

    @foreach($inventory_countries as $country)
    <td class="inventories_col_{{ $country->name }}">
            {{ $inventory->country_qty($country->id) }}
    </td>
    @endforeach


    <td class="inventories_col_sold">
        {{ $inventory->sold }}
    </td>

    <td class="inventories_col_spoiled">
        {{ $inventory->spoiled }}
    </td>

    <td class="inventories_col_condemn">
        {{ $inventory->condemn }}
    </td>

    <td class="inventories_col_total">
        {{ $inventory->total }}
    </td>

    <td class="inventories_col_diffrence">
        {{ $inventory->diffrence }}
    </td>

    <td class="inventories_col_remark">
        {{ $inventory->remark }}
    </td>

    <td class="inventories_col_freight">
        {{ $inventory->fd['fd_length'] .' × '. $inventory->fd['fd_width'] .' × '. $inventory->fd['fd_height'] .' × '. $inventory->fd['fd_weight'] }}
    </td>

    <td class="inventories_col_schedule">
        {{ $inventory->schedule }}
    </td>

    <td class="inventories_col_action actions_column">
            <!--view-->
            <a href="{{ _url('/inventory/'.$inventory->id) }}" title="{{ cleanLang(__('lang.view')) }}"
                class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm">
                <i class="ti-new-window"></i>
            </a>
        <!--action button-->
    </td>
</tr>
@endforeach
<!--each row-->