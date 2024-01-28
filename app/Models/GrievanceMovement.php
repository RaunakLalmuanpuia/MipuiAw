<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrievanceMovement extends Model
{
    use HasFactory;
    /** GUARDED EMPTY MEANS THAT ALL ATTRIBUTES ARE MASS ASSIIGNABLE */
    protected $guarded = [];
    protected $with = ['from','to'];

    use SoftDeletes;

    public function grievance(){
        return $this->belongsTo(Grievance::class);
    }
   
    public function action(): BelongsTo{
        return $this->belongsTo(Action::class);
    }

    public function moveable():MorphTo{
        return $this->morphTo();
    }

    public function from(){
        return $this->morphTo('from');
    }

    public function to(){
        return $this->morphTo('to');
    }

    public function scopeSubLatest( $builder,$id){
        return $builder->where('sub_department_owner',$id);
    }
}
