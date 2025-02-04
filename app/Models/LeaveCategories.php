<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveCategories extends Model
{
    use HasFactory;

    protected $table = 'leave_categories';

    public function administration(){
        return $this->hasMany(Administration::class);
    }
}
