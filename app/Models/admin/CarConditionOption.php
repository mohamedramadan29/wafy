<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarConditionOption extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function question()
    {
        return $this->belongsTo(CarConditionQuestion::class,'question_id');
    }
}
