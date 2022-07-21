<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for leads
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Country;
use App\Models\InventoryCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Log;

class InventoryCountryRepository {

    /**
     * The inventory_country repository instance.
     */
    protected $inventory_country;

    /**
     * The country model instance.
     */
    protected $country;

    /**
     * Inject dependecies
     */
    public function __construct(Country $country, InventoryCountry $inventory_country) {
        $this->country = $country;
        $this->inventory_country = $inventory_country;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @return object collection
     */
    public function search($id = '') {

       
    }

    /**
     * Get model
     * @return object country collection
     */
    public function get() {
        $countries = $this->country->newQuery();

        // select all
        $countries->selectRaw('*');
        
        return $countries->get();
    }

    /**
     * Get inventory countries
     * @return object country collection
     */
    public function get_inventory_countries() {
        $countries = $this->country->newQuery();

        // select all
        $countries->selectRaw('*');

        // using in inventory
        $countries->where('is_inventory',1);
        
        return $countries->get();
    }

    /**
     * Create a new record
     * @param array $position new record position
     * @return mixed object|bool
     */
    public function create($position = '') {

        //validate
        if (!is_numeric($position)) {
            Log::error("validation error - invalid params", ['process' => '[LeadRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project_id' => 1]);
            return false;
        }

        //save new user
        $country = new $this->country;


        //save and return id
        if ($country->save()) {
            return $country->id;
        } else {
            return false;
        }
    }

    /**
     * add inventory item quantity by countries 
     * @param int $item_id the id of the inventory
     * @param int $country_id if specified, only this country will be added
     * @param int $quantity if specified, quantity on the item
     * @return bool
     */
    public function add($item_id = '', $country_id = '', $quantity = 0) {

        $list = [];

        //validation
        if (!is_numeric($item_id)) {
            return $list;
        }

        //add only to the specified user
        if (is_numeric($country_id)) {
            $add = new $this->inventory_country;
            $add->inventory_id = $item_id;
            $add->country_id = $country_id;
            $add->quantity = $quantity;
            $add->save();
            $list[] = $country_id;
            //return array of country_id
            return $list;
        }

        //add each user in the post request
        if (request()->filled('qty_country')) {
            foreach (request('qty_country') as $country_id => $quantity) {
                $add = new $this->inventory_country;
                $add->inventory_id = $item_id;
                $add->country_id = $country_id;
                $add->quantity = $quantity;
                $add->save();
                $list[] = $country_id;
            }
            //return array of users
            return $list;
        }
        //return array of users
        return $list;
    }
 
}