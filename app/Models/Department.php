<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id','organization_name','organization_code',
        'organization_type','organization_address',
        'pincode',
    ];

    public function subDepartment(){
        return $this->hasMany(SubDepartment::class);
    }

    public function grievances(){
        return $this->hasMany(Grievance::class);
    }

    public function grievance(){
        return $this->hasOne(Grievance::class);
    }

    // public function user():BelongsTo{
    //     return $this->belongsTo(User::class);
    // }
    public function user():HasOne{
        return $this->hasOne(User::class);
    }

    public function category():HasMany{
        return $this->hasMany(Category::class);
    }

    //POLYMORPHIC
    public function grievanceMovements():MorphMany{
        return $this->morphMany(GrievanceMovement::class,'moveable');
    }

    public function receivedGrievances(){
        return $this->morphMany(GrievanceMovement::class,'from');
    }

    public function sentGrievances(){
        return $this->morphMany(GrievanceMovement::class,'to');
    }
}
