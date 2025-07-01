<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SisRolePartnerType extends Model
{
    use HasFactory;

    protected $table = 'sisrolepartnertype';

    protected $fillable = [
        'id_user',
        'id_role',
    ];

    /**
     * Relationship to user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relationship to role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
}