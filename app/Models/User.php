<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use DB;
  
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected function getPermission($parentId){
        $dataArray=DB::table('permissions')->select('*')
         ->where('parent_id', '=',  $parentId)->orderBy('order_by', 'asc')->get();
        return $dataArray;
    }

  
    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
  
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array

     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
  
    /**
     * The attributes that should be cast.
     *
     * @var array

     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    protected function getRolename($userId){
        $dataArray=DB::table('model_has_roles')->select('roles.name')
        ->leftJoin('roles', 'model_has_roles.role_id', 'roles.id') 
        ->where('model_has_roles.model_id', '=',  $userId)->first();
        if($dataArray!=''){ 
            return $dataArray->name;
        }
    }
    
}
