<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for leads
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Log;

class InventoryRepository {

    /**
     * The inv repository instance.
     */
    protected $inventory;

    /**
     * Inject dependecies
     */
    public function __construct(Inventory $inventory) {
        $this->inventory = $inventory;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @return object lead collection
     */
    public function search($id = '') {

        $inventories = $this->inventory->newQuery();

        //joins
        // $leads->leftJoin('users', 'users.id', '=', 'leads.lead_creatorid');

        // select all
        $inventories->selectRaw('*');


        //default where
        $inventories->whereRaw("1 = 1");

        if (is_numeric($id)) {
            $inventories->where('id', $id);
        }

        //filter: booked date (start)
        if (request()->filled('filter_next_booked_date_from')) {
            $inventories->where('next_booked_date_from', '>=', request('filter_next_booked_date_from'));
        }

        //filter: booked date (end)
        if (request()->filled('filter_next_booked_date_to')) {
            $inventories->where('next_booked_date_to', '<=', request('filter_next_booked_date_to'));
        }

        //filter: add date (start)
        // if (request()->filled('filter_lead_last_contacted_start')) {
        //     $inventories->where('lead_last_contacted', '>=', request('filter_lead_last_contacted_start'));
        // }


        //search: various client columns and relationships (where first, then wherehas)
        // if (request()->filled('search_query') || request()->filled('query')) {
        //     $inventories->where(function ($query) {
        //         $query->Where('lead_id', '=', request('search_query'));
        //         $query->orWhere('lead_created', 'LIKE', '%' . date('Y-m-d', strtotime(request('search_query'))) . '%');
        //         $query->orWhereRaw("YEAR(lead_last_contacted) = ?", [request('search_query')]); //example binding
        //         $query->orWhere('lead_title', 'LIKE', '%' . request('search_query') . '%');
        //         $query->orWhereHas('tags', function ($q) {
        //             $q->where('tag_title', 'LIKE', '%' . request('search_query') . '%');
        //         });
        //     });
        // }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('name', request('orderby'))) {
                $inventories->orderBy(request('orderby'), request('sortorder'));
            }
            //others
            switch (request('orderby')) {
            case 'quantity':
                $inventories->orderBy('quantity', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $inventories->orderBy('id', 'desc');
        }

        $inventories->with('inventory_countries');

        // Get the results and return them.
        return $inventories->paginate(config('system.settings_system_pagination_limits'));
    }

    /**
     * Create a new record
     * @param array $data item qty by country json
     * @return mixed object|bool
     */
    public function create($data = '') {

        //validate
        if (!$data) {
            Log::error("validation error - invalid params", ['process' => '[InventoryRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project_id' => 1]);
            return false;
        }

        //save new user
        $inventory = new $this->inventory;

        $inventory->name = request('name');
        $inventory->quantity = request("quantity");
        $inventory->serial_number = request('serial_number');
        $inventory->sold = request('sold');
        $inventory->spoiled = request('spoiled');
        $inventory->total = request('total');
        $inventory->invoice_number = request('invoice_number');
        $inventory->remark = request('remark');
        $inventory->highlighted = $data['highlighted'];
        $inventory->freight_dimensions = $data['freight_dimensions'];
        $inventory->next_booked_date_from = request('date_start');
        $inventory->next_booked_date_to = request('date_due');

        //save and return id
        if ($inventory->save()) {
            return $inventory->id;
        }

        return false;
        
    }

 
}