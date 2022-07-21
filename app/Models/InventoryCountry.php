<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryCountry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'inventory_id',
        'country_id',
        'quantity'
    ];

    /**
     * The Quantity that are from the countries.
     */
    public function inventory() {
        return $this->belongsTo('App\Models\Inventory', 'inventory_id');
    }

}
