<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile','gender','designation',
        'address','pincode','alternate_mobile',
        'notification','active',
        'role_id','address','district'
        

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function setPasswordAttribute($value ){
    //     $this->attributes['password']= $value;
    // }

    public function grievance(){
        return $this->hasOne(Grievance::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    // public function department(): HasOne{
    //     return $this->hasOne(Department::class);
    // }

    // public function subDepartment():HasOne{
    //     return $this->hasOne(SubDepartment::class);
    // }

    public function subDepartment():BelongsTo{
        return $this->belongsTo(SubDepartment::class);
    }
    
    public function department(){
        return $this->belongsTo(Department::class);
    }
   
}
