<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name','label','visible',
    ];

    public function grievenceMovement():HasOne{
        return $this->hasOne(GrievanceMovement::class);
    }

    public function grievence():HasOne{
        return $this->hasOne(Grievance::class);
    }
}
