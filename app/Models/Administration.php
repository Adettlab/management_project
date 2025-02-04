<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administration extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'leave_category_id',
        'start_date',
        'end_date',
        'description',
        'bring_laptop',
        'contacted',
    ];

    public function leavecategory(){
        return $this->belongsTo(LeaveCategories::class, 'leave_category_id', 'id');
    }
}

