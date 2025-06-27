<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Relationship to permissions
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
