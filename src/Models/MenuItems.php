<?php

namespace Harimayco\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MenuItems extends Model
{

    protected $table = null;

    protected $fillable = ['label', 'link', 'parent', 'sort', 'class', 'menu', 'depth', 'role_id','website_id','type','uuid'];

        
     
    public function __construct(array $attributes = [])
    {
        //parent::construct( $attributes );
        $this->table = config('menu.table_prefix') . config('menu.table_name_items');
    }

    public function getsons($id)
    {
        return $this->where("parent", $id)->get();
    }
    public function getall($id)
    {
        return $this->where("menu", $id)->orderBy("sort", "asc")->get();
    }

    public static function getNextSortRoot($menu)
    {
        return self::where('menu', $menu)->max('sort') + 1;
    }

    public function parent_menu()
    {
        // return $this->belongsTo('Harimayco\Menu\Models\Menus', 'menu');
        return $this->belongsTo('Harimayco\Menu\Models\MenuItems', ['parent','website_id'],['uuid','website_id'] )->orderBy('sort', 'ASC');
    }

    public function child()
    {
        //return $this->hasMany('Harimayco\Menu\Models\MenuItems', 'parent')->orderBy('sort', 'ASC');
        // return $this->hasMany('Harimayco\Menu\Models\MenuItems', ['parent','wb id'], 'uuid'])->orderBy('sort', 'ASC');
         return $this->hasMany('Harimayco\Menu\Models\MenuItems', ['uuid','website_id'],['parent','website_id'] )->orderBy('sort', 'ASC');
    }
    public function children_menu()
    {
        return $this->hasMany('Harimayco\Menu\Models\MenuItems', 'parent')->orderBy('sort', 'ASC');
        // return $this->hasMany('Harimayco\Menu\Models\MenuItems', ['parent','wb id'], 'uuid'])->orderBy('sort', 'ASC');
        // return $this->hasMany('Harimayco\Menu\Models\MenuItems', ['uuid','website_id'],['parent','website_id'] )->orderBy('sort', 'ASC');
    }
}
