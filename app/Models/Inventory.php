<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'serial_number',
        'quantity',
        'freight_dimensions'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'next_booked_date_from'  => 'date:d',
        'next_booked_date_to'  => 'date:d-M-Y',
    ];

    /**
     * The Quantity that are from the countries.
     */
    public function inventory_countries() {
        return $this->hasMany('App\Models\InventoryCountry', 'inventory_id', 'id');
    }

    /**
     * 
     * Freight Dimensions custom attrib
     */
    public function getFdAttribute()
    {   
        $fd = json_decode($this->freight_dimensions, true);
        
        return $fd;
    }

    /**
     * 
     * Schedule date format
     */
    public function getScheduleAttribute()
    {   
        $format = 'd M Y';
        $Y1 = date("Y", strtotime($this->next_booked_date_from));
        $Y2 = date("Y", strtotime($this->next_booked_date_to));
        $M1 = date("m", strtotime($this->next_booked_date_from));
        $M2 = date("m", strtotime($this->next_booked_date_to));
        
        if ($Y1 < $Y2) {
            $format = "d M Y";
        }
        else {
            if($M1 < $M2){
                $format = "d M";
            }else
            {
                $format = 'd';
            }
        }

        return \Carbon\Carbon::parse($this->next_booked_date_from)->format($format) .' - '.  \Carbon\Carbon::parse($this->next_booked_date_to)->format('d M Y');
    }

    /**
     * 
     * Inventory quantity country
     * @param: country id
     * @return: Integer quantity of inventory by countries
     */
    public function country_qty($country_id)
    {  
        $inventory_country = $this->inventory_countries->where('country_id', $country_id)->first();
       
        if($inventory_country){
            return $inventory_country->quantity;
        }else{
            return 0;
        }
      
    }

    /**
     * 
     * Freight Dimensions custom attrib
     */
    public function getCondemnAttribute()
    {   
        return 0;
    }

    /**
     * 
     * Freight Dimensions custom attrib
     */
    public function getDiffrenceAttribute()
    {   
        $diff = $this->quantity - $this->total;
        return $diff;
    }
}
