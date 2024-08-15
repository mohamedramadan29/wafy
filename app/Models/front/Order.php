<?php

namespace App\Models\front;

use App\Models\admin\InsepctionCenter;
use App\Models\admin\InspectionType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function question()
    {
        return $this->hasOne(OrderQuestion::class, 'order_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class,'buyer_id');
    }

    public function center()
    {
        return $this->belongsTo(InsepctionCenter::class,'inspection_center');
    }
    public function inspectiontype()
    {
        return $this->belongsTo(InspectionType::class,'inspection_type');
    }
}
