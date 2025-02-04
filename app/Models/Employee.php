<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_id',
        'work_email',
        'photo',
        'nik',
        'status_employee',
        'birth_date',
        'phone_number',
        'telegram_link',
        'address',
        'join_date',
        'education',
    ];
    protected $casts = [
        'status_employee' => 'string', // untuk memastikan kolom ini diperlakukan sebagai string
    ];
    public static function getStatuses()
    {
        return ['Kontrak', 'Freelance', 'Tetap', 'Tenaga Ahli'];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'project_employees', 'project_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_employees');
    }

    public function administration(){
        return $this->hasOne(Administration::class);
    }
}
