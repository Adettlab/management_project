<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiMenuWeb extends Model
{
    use HasFactory;

    protected $table = 'simenuweb';

    protected $fillable = [
        'teks', // pengganti 'name'
        'navigate_url',
        'image_url',
        'tingkat',
        'sort_order',
        'is_visible',
        'parent_menu_id'
        // TIDAK ADA allow_* fields di sini!
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'tingkat' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Relationship to permissions (hanya untuk custom permissions)
     */
    public function permissions()
    {
        return $this->hasMany(SisRolePartnerTypeMenuWeb::class, 'menu_id');
    }

    /**
     * Self-referencing relationship (parent menu)
     */
    public function parentMenu()
    {
        return $this->belongsTo(SiMenuWeb::class, 'parent_menu_id');
    }

    /**
     * Self-referencing relationship (child menus)
     */
    public function childMenus()
    {
        return $this->hasMany(SiMenuWeb::class, 'parent_menu_id')->orderBy('sort_order');
    }

    /**
     * Scope untuk menu yang visible
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope untuk main menus
     */
    public function scopeMainMenus($query)
    {
        return $query->whereNull('parent_menu_id')->orderBy('sort_order');
    }
}
