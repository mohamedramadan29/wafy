<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarConditionQuestion extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function options()
    {
        return $this->hasMany(CarConditionOption::class,'question_id');
    }

    public function questionmark()
    {
        return $this->belongsTo(TraderMark::class,'car_mark');
    }


}
