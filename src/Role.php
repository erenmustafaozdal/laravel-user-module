<?php

namespace ErenMustafaOzdal\LaravelUserModule;

use Cartalyst\Sentinel\Roles\EloquentRole as Sentinel;
use Carbon\Carbon;
use ErenMustafaOzdal\LaravelModulesBase\Traits\ModelDataTrait;

class Role extends Sentinel
{
    use ModelDataTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'permissions'];





    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * query filter with id scope
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $request)
    {
        // filter id
        if ($request->has('id')) {
            $query->where('id',$request->get('id'));
        }
        // filter first_name
        if ($request->has('name')) {
            $query->where('name', 'like', "%{$request->get('name')}%");
        }
        // filter status
        if ($request->has('slug')) {
            $query->where('slug', 'like', "%{$request->get('slug')}%");
        }
        // filter created_at
        if ($request->has('created_at_from')) {
            $query->where('created_at', '>=', Carbon::parse($request->get('created_at_from')));
        }
        if ($request->has('created_at_to')) {
            $query->where('created_at', '<=', Carbon::parse($request->get('created_at_to')));
        }
        return $query;
    }





    /*
    |--------------------------------------------------------------------------
    | Model Set and Get Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * Get the permissions attribute.
     *
     * @param array $value
     * @return string
     */
    public function getPermissionsAttribute($value)
    {
        if ( ! $value) {
            return [];
        }

        $permissions = [];
        foreach(json_decode($value, true) as $route => $permission) {
            $permissions[$route] = $permission ? true : false;
        }
        return $permissions;
    }

    /**
     * Get the permission collect attribute.
     *
     * @return string
     */
    public function getPermissionCollectAttribute()
    {
        return $this->permissions ? collect( $this->permissions ) : collect();
    }
}
