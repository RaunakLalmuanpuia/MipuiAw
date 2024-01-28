<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function department():BelongsTo{
        return $this->belongsTo(Department::class);
    }

    public function grievance():BelongsTo {
        return $this->belongsTo(Grievance::class);
    }
}
