<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;
class Grievance extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    /** GUARDED EMPTY MEANS THAT ALL ATTRIBUTES ARE MASS ASSIIGNABLE */
    protected $guarded = [];

    protected $appends = ['grievance_text'];

    public function grievanceMovement(){
        return $this->hasMany(GrievanceMovement::class);//->latestOfMany();
    }
    public function subDepartment(){
        return $this->belongsToMany(SubDepartment::class,'grievance_movements','sub_department_owner','grievance_id');
    }

    public function category(){
        return $this->hasMany(Category::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function action(): BelongsTo{
        return $this->belongsTo(Action::class);
    }
    
    public function getGrievanceTextAttribute()
    {
        return Str::limit($this->grievance_description, 20, '...');
    }

    public function latestGrievanceMovement():HasOne {
        return $this->hasOne(GrievanceMovement::class)->latestOfMany();
    }

    public function subDepartmentLatestStatus(){
        return $this->hasMany(SubDepartmentLatestStatus::class);
    }

}
