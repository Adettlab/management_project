<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Permission;
use App\Models\Page;
use App\Models\Employee;

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

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * Get default permissions based on old logic
     */
    private function getDefaultPermissions($pageName, $action = 'view')
    {
        // Admin has full access (old logic)
        if ($this->role === 'admin') {
            return true;
        }

        // Jika user tidak punya employee record, tidak ada akses
        if (!$this->employee) {
            return false;
        }

        $roleName = $this->employee->role->name ?? '';

        // Default permissions berdasarkan role lama
        $defaultPermissions = [
            'Project Director' => [
                'projects' => ['view', 'create', 'update', 'delete'],
                'tasks' => ['view', 'create', 'update', 'delete'],
                'activity' => ['view'],
                'dashboard' => ['view'],
                'administration' => ['view'],
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

        if (isset($defaultPermissions[$roleName][$pageName])) {
            return in_array($action, $defaultPermissions[$roleName][$pageName]);
        }

        return false;
    }

    /**
     * Main permission check - Custom permission ATAU default logic
     */
    public function hasPermission($pageName, $action = 'view')
    {
        // Admin selalu punya akses penuh
        if ($this->role === 'admin') {
            return true;
        }

        // Cek apakah ada custom permission untuk page ini
        $page = Page::where('name', $pageName)->first();
        
        if ($page) {
            $permission = $this->permissions()
                              ->where('page_id', $page->id)
                              ->first();

            // Jika ada custom permission, gunakan itu
            if ($permission) {
                return match($action) {
                    'create' => $permission->allow_create,
                    'view' => $permission->allow_view,
                    'update' => $permission->allow_update,
                    'delete' => $permission->allow_delete,
                    default => $permission->allow_view,
                };
            }
        }

        // Jika tidak ada custom permission, gunakan default logic lama
        return $this->getDefaultPermissions($pageName, $action);
    }

    public function canAccessMenu($pageName)
    {
        return $this->hasPermission($pageName, 'view');
    }

    public function canCreate($pageName)
    {
        return $this->hasPermission($pageName, 'create');
    }

    public function canUpdate($pageName)
    {
        return $this->hasPermission($pageName, 'update');
    }

    public function canDelete($pageName)
    {
        return $this->hasPermission($pageName, 'delete');
    }

    public function getPagePermissions($pageName)
    {
        if ($this->role === 'admin') {
            return [
                'allow_create' => true,
                'allow_view' => true,
                'allow_update' => true,
                'allow_delete' => true,
            ];
        }

        $page = Page::where('name', $pageName)->first();
        
        if ($page) {
            $permission = $this->permissions()
                              ->where('page_id', $page->id)
                              ->first();

            if ($permission) {
                return [
                    'allow_create' => $permission->allow_create,
                    'allow_view' => $permission->allow_view,
                    'allow_update' => $permission->allow_update,
                    'allow_delete' => $permission->allow_delete,
                ];
            }
        }

        // Return default permissions
        return [
            'allow_create' => $this->getDefaultPermissions($pageName, 'create'),
            'allow_view' => $this->getDefaultPermissions($pageName, 'view'),
            'allow_update' => $this->getDefaultPermissions($pageName, 'update'),
            'allow_delete' => $this->getDefaultPermissions($pageName, 'delete'),
        ];
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isProjectDirector()
    {
        return $this->employee && $this->employee->role->name === 'Project Director';
    }

    public function canManageProjects()
    {
        return $this->isAdmin() || $this->isProjectDirector();
    }

    public function hasCustomPermissions()
    {
        return $this->permissions()->exists();
    }
    
}