<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

	/**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'address',
        'city',
        'country'
    ];
    //
    public function users() {

        return $this->belongsToMany(User::class,'users_companies');
            
     }
}
