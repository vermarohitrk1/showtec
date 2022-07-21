<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    

		/**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
    ];
	
	public function roles() {

	   return $this->belongsToMany(Role::class,'roles_permissions');
		   
	}
	public function users() {

	   return $this->belongsToMany(User::class,'users_permissions');
		   
}
}
