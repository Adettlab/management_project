<?php
// File: app/Models/User.php (Simplified - tetap menggunakan logic by code)

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationship to custom permissions (HANYA jika ada custom permission)
     */
    public function permissions()
    {
        return $this->hasMany(SisRolePartnerTypeMenuWeb::class, 'id_user');
    }

    /**
     * Relationship to role partner types
     */
    public function rolePartnerTypes()
    {
        return $this->hasMany(SisRolePartnerType::class, 'id_user');
    }

    /**
     * Relationship to employee
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * Get default permissions based on EXISTING LOGIC BY CODE
     * INI TETAP SAMA SEPERTI SEBELUMNYA - TIDAK BERUBAH
     */
    private function getDefaultPermissions($menuName, $action = 'view')
    {
        // Admin has full access (logic lama)
        if ($this->role === 'admin') {
            return true;
        }

        // Jika user tidak punya employee record, tidak ada akses
        if (!$this->employee) {
            return false;
        }

        $roleName = $this->employee->role->name ?? '';

        // Default permissions berdasarkan role lama - TETAP SAMA
        $defaultPermissions = [
            'Project Director' => [
                'projects' => ['view', 'create', 'update', 'delete'],
                'tasks' => ['view', 'create', 'update', 'delete'],
                'activity' => ['view'],
                'dashboard' => ['view'],
                'admin' => ['view', 'create', 'update', 'delete'],
            ],
            'Analyst' => [
                'projects' => ['view'], // hanya project yang dia ikuti
                'tasks' => ['view', 'create', 'update'],
                'activity' => ['view'],
                'dashboard' => ['view'],
            ],
            'Designer' => [
                'projects' => ['view'], // hanya project yang dia ikuti
                'tasks' => ['view', 'create', 'update'],
                'activity' => ['view'],
                'dashboard' => ['view'],
            ],
            'Engineer Web' => [
                'projects' => ['view'], // hanya project yang dia ikuti
                'tasks' => ['view', 'create', 'update'],
                'activity' => ['view'],
                'dashboard' => ['view'],
            ],
            'Engineer Mobile' => [
                'projects' => ['view'], // hanya project yang dia ikuti
                'tasks' => ['view', 'create', 'update'],
                'activity' => ['view'],
                'dashboard' => ['view'],
            ],
            'Engineer Tester' => [
                'projects' => ['view'], // hanya project yang dia ikuti
                'tasks' => ['view', 'create', 'update'],
                'activity' => ['view'],
                'dashboard' => ['view'],
            ],
        ];

        if (isset($defaultPermissions[$roleName][$menuName])) {
            return in_array($action, $defaultPermissions[$roleName][$menuName]);
        }

        return false;
    }

    /**
     * Main permission check - TETAP MENGGUNAKAN LOGIC BY CODE
     * Custom permission HANYA sebagai override jika ada
     */
    public function hasPermission($menuName, $action = 'view')
    {
        // Admin selalu punya akses penuh
        if ($this->role === 'admin') {
            return true;
        }

        // CEK CUSTOM PERMISSION DULU - HANYA jika ada
        $menu = SiMenuWeb::where('teks', $menuName)->first();
        
        if ($menu) {
            $customPermission = $this->permissions()
                                     ->where('menu_id', $menu->id)
                                     ->first();

            // Jika ada custom permission, gunakan itu (OVERRIDE)
            if ($customPermission) {
                return match($action) {
                    'create' => $customPermission->allow_create,
                    'view' => $customPermission->allow_view,
                    'update' => $customPermission->allow_update,
                    'delete' => $customPermission->allow_delete,
                    'export' => $customPermission->allow_export,
                    'import' => $customPermission->allow_import,
                    'edit' => $customPermission->allow_edit,
                    default => $customPermission->allow_view,
                };
            }
        }

        // Jika TIDAK ADA custom permission, gunakan DEFAULT LOGIC BY CODE
        return $this->getDefaultPermissions($menuName, $action);
    }

    /**
     * Method-method convenience - TETAP SAMA
     */
    public function canAccessMenu($menuName)
    {
        return $this->hasPermission($menuName, 'view');
    }

    public function canCreate($menuName)
    {
        return $this->hasPermission($menuName, 'create');
    }

    public function canUpdate($menuName)
    {
        return $this->hasPermission($menuName, 'update');
    }

    public function canDelete($menuName)
    {
        return $this->hasPermission($menuName, 'delete');
    }

    public function canExport($menuName)
    {
        return $this->hasPermission($menuName, 'export');
    }

    public function canImport($menuName)
    {
        return $this->hasPermission($menuName, 'import');
    }

    public function canEdit($menuName)
    {
        return $this->hasPermission($menuName, 'edit');
    }

    /**
     * Check if user is admin - TETAP SAMA
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is project director - TETAP SAMA
     */
    public function isProjectDirector()
    {
        return $this->employee && $this->employee->role->name === 'Project Director';
    }

    /**
     * Check if user can manage projects - TETAP SAMA
     */
    public function canManageProjects()
    {
        return $this->isAdmin() || $this->isProjectDirector();
    }

    /**
     * Check if user has custom permissions (NEW - untuk UI)
     */
    public function hasCustomPermissions()
    {
        return $this->permissions()->exists();
    }

    /**
     * Get menu permissions untuk form (NEW - untuk UI)
     */
    public function getMenuPermissions($menuName)
    {
        if ($this->role === 'admin') {
            return [
                'allow_create' => true,
                'allow_view' => true,
                'allow_update' => true,
                'allow_delete' => true,
                'allow_export' => true,
                'allow_import' => true,
                'allow_edit' => true,
                'is_visible' => true,
            ];
        }

        $menu = SiMenuWeb::where('teks', $menuName)->first();
        
        if ($menu) {
            $permission = $this->permissions()
                              ->where('menu_id', $menu->id)
                              ->first();

            if ($permission) {
                return [
                    'allow_create' => $permission->allow_create,
                    'allow_view' => $permission->allow_view,
                    'allow_update' => $permission->allow_update,
                    'allow_delete' => $permission->allow_delete,
                    'allow_export' => $permission->allow_export,
                    'allow_import' => $permission->allow_import,
                    'allow_edit' => $permission->allow_edit,
                    'is_visible' => $permission->is_visible,
                ];
            }
        }

        // Return default permissions dari logic by code
        return [
            'allow_create' => $this->getDefaultPermissions($menuName, 'create'),
            'allow_view' => $this->getDefaultPermissions($menuName, 'view'),
            'allow_update' => $this->getDefaultPermissions($menuName, 'update'),
            'allow_delete' => $this->getDefaultPermissions($menuName, 'delete'),
            // Field yang tidak digunakan selalu false
            'allow_export' => false,
            'allow_import' => false,
            'allow_edit' => false,
            'is_visible' => true,
        ];
    }
}