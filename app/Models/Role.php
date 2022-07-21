<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Role extends Model
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
	public function permissions() {

	   return $this->belongsToMany(Permission::class,'roles_permissions');
		   
	}
	public function users() {

	   return $this->belongsToMany(User::class,'users_roles');
		   
	}

	public function rolehasPermission($perm)
	{
		$permission = DB::table('permissions')->where('slug',$perm)->first();
		$role = Auth::user()->role(1);
		return (bool) DB::table('roles_permissions')->where('role_id',$role->id)->where('permission_id',$permission->id)->count();
	}

	// public function rolehasPermission($perm, $role)
	// {
	// 	return (bool) DB::table('roles_permissions')->where('role_id',$role)->where('permission_id',$perm)->count();
	// }
}
