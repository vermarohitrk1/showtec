<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Permissions\HasPermissionsTrait;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function companies() {

        return $this->belongsToMany(Company::class,'users_companies');
            
    }
    public function department() {
        return $this->belongsTo(Department::class);
    }
    public function roles() {

        return $this->belongsToMany(Role::class,'users_roles');
            
    }
  
    public $is_team = true;
        /**
     * The tasks that are assigned to the user.
     */
    public function userhasRole($user, $role)
    {
        return (bool) DB::table('users_roles')->where('role_id',$role)->where('user_id',$user)->count();

    }
    /**
     * 
     * get user role by ID
     */
    public static function role($user_id)
    {
        $role = DB::table('users_roles')->where('user_id',$user_id)->first();
        if($role){
            return Role::where('id', $role->role_id)->first();
        }else{
            return false;
        }
    }
    /**
     * 
     * Get user role name by ID
     */
    public static function roleName($user_id)
    {
        $user_role = DB::table('users_roles')->where('user_id',$user_id)->first();
        if($user_role){
            $role = Role::where('id', $user_role->role_id)->first();
            return $role->name;
        }else{
            return null;
        }
    }
    /**
     * get the users avatar. if it does not exist return the default avatar
     * @return string
     */
    public function getAvatarAttribute() {
        return getUsersAvatar($this->avatar_directory, $this->avatar_filename);
    }
    /**
     * get the users full name
     * @return string
     */
    public function getFUllNameAttribute() {
        return $this->first_name.' '. $this->last_name;
    }
    public function settings(){
        return $this->hasOne(UserSetting::class);
    }

}
