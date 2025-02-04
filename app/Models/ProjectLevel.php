<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLevel extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function projects()
    {
        return $this->hasMany(Project::class, 'project_level_id');
    }
}
