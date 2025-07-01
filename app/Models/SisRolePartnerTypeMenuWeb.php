<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SisRolePartnerTypeMenuWeb extends Model
{
    use HasFactory;

    protected $table = 'sisrolepartnertypemenuweb';

    protected $fillable = [
        'id_user',
        'menu_id',
        'id_role', // Nullable
        
        // SEMUA allow_* fields ada di sini
        'allow_create',
        'allow_view',
        'allow_update',
        'allow_delete',
        'allow_export',
        'allow_import',
        'allow_edit',
        'is_visible',
        
        'menu_id_ref' // Nullable
    ];

    protected $casts = [
        'allow_create' => 'boolean',
        'allow_view' => 'boolean',
        'allow_update' => 'boolean',
        'allow_delete' => 'boolean',
        'allow_export' => 'boolean',
        'allow_import' => 'boolean',
        'allow_edit' => 'boolean',
        'is_visible' => 'boolean',
    ];

    /**
     * Relationship to user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relationship to menu
     */
    public function menu()
    {
        return $this->belongsTo(SiMenuWeb::class, 'menu_id');
    }

    /**
     * Relationship to role (nullable)
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    /**
     * Relationship to menu reference (nullable)
     */
    public function menuRef()
    {
        return $this->belongsTo(SiMenuWeb::class, 'menu_id_ref');
    }

    /**
     * Get user permission for specific menu
     */
    public static function getUserMenuPermission($userId, $menuId)
    {
        return self::where('id_user', $userId)
                   ->where('menu_id', $menuId)
                   ->first();
    }

    /**
     * Check if user has specific permission for menu
     */
    public static function hasPermission($userId, $menuId, $action)
    {
        $permission = self::getUserMenuPermission($userId, $menuId);
        
        if (!$permission) {
            return false;
        }

        return match($action) {
            'create' => $permission->allow_create,
            'view' => $permission->allow_view,
            'update' => $permission->allow_update,
            'delete' => $permission->allow_delete,
            'export' => $permission->allow_export,
            'import' => $permission->allow_import,
            'edit' => $permission->allow_edit,
            default => $permission->allow_view,
        };
    }
}