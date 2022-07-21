<?php
namespace App\Permissions;

use App\Models\Permission;
use App\Models\Role;
use DB;
use Auth;

trait HasPermissionsTrait {

   public function givePermissionsTo(... $permissions) {

    $permissions = $this->getAllPermissions($permissions);
    dd($permissions);
    if($permissions === null) {
      return $this;
    }
    $this->permissions()->saveMany($permissions);
    return $this;
  }

  public function withdrawPermissionsTo( ... $permissions ) {

    $permissions = $this->getAllPermissions($permissions);
    $this->permissions()->detach($permissions);
    return $this;

  }

  public function refreshPermissions( ... $permissions ) {

    $this->permissions()->detach();
    return $this->givePermissionsTo($permissions);
  }

  public function hasPermissionTo($permission) {

    return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
  }

  public function hasPermissionThroughRole($permission) {

    foreach ($permission->roles as $role){
      if($this->roles->contains($role)) {
        return true;
      }
    }
    return false;
  }

  public function hasRole( ... $roles ) {

    foreach ($roles as $role) {
      if ($this->roles->contains('slug', $role)) {
        return true;
      }
    } 
    return false;
  }

  public function roles() {

    return $this->belongsToMany(Role::class,'users_roles');

  }
  public function permissions() {

    return $this->belongsToMany(Permission::class,'users_permissions');

  }

  // public function roleHasPermission($permission) {

  //   return (bool) $this->roles->rolehasPermission('slug', $permission)->count();
  // }
	public function roleHasPermission($perm)
	{

		if(!($permission = DB::table('permissions')->where('slug',$perm)->first())){
      return false;
    }
    if(!($role = Auth::user()->role(Auth::user()->id))){
      return false;
    }
		return (bool) DB::table('roles_permissions')->where('role_id',$role->id)->where('permission_id',$permission->id)->count();
	}
  protected function hasPermission($permission) {

    return (bool) $this->permissions->where('slug', $permission->slug)->count();
  }

  protected function getAllPermissions(array $permissions) {

    return Permission::whereIn('slug',$permissions)->get();
    
  }

}
?>