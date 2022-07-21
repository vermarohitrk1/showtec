<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

	/**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'status'
    ];
    //
    public function user() {
        return $this->hasMany(Department::class);
            
     }
}
