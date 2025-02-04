<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'color', 'is_default'];

    public function projects()
    {
        return $this->hasMany(Project::class, 'project_status_id');
    }
}
