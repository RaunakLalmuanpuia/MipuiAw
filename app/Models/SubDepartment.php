<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubDepartment extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'id','organization_name','organization_code',
        'organization_type','organization_address',
        'pincode','department_id',
    ];
    
    public function department(){
        return $this->belongsTo(Department::class);
    }

    // public function user():BelongsTo{
    //     return $this->belongsTo(User::class);
    // }
    public function user():HasOne{
        return $this->hasOne(User::class);
    }

     //POLYMORPHIC
     public function grievanceMovements():MorphMany{
        return $this->morphMany(GrievanceMovement::class,'moveable');
    }
}
