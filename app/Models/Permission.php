<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'page_id', 
        'allow_create', 
        'allow_view', 
        'allow_update', 
        'allow_delete'
    ];

    /**
     * Relationship to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to page
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}

