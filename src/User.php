<?php

namespace ErenMustafaOzdal\LaravelUserModule;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use ErenMustafaOzdal\LaravelModulesBase\Traits\ModelDataTrait;
use ErenMustafaOzdal\LaravelModulesBase\Repositories\FileRepository;

class User extends SentinelUser
{
    use ModelDataTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'is_active', 'photo','permissions'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];





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
        if ($request->has('first_name')) {
            $query->where('first_name', 'like', "%{$request->get('first_name')}%")
                ->orWhere('last_name', 'like', "%{$request->get('first_name')}%");
        }
        // filter first_name
        if ($request->has('last_name')) {
            $query->where('first_name', 'like', "%{$request->get('last_name')}%")
                ->orWhere('last_name', 'like', "%{$request->get('last_name')}%");
        }
        // filter status
        if ($request->has('status')) {
            $query->where('is_active',$request->get('status'));
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
     * Set password encrypted
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] =  Hash::make($password);
    }

    /**
     * Get the is_super_admin attribute.
     *
     * @param boolean $value
     * @return string
     */
    public function getIsSuperAdminAttribute($value)
    {
        return $value == 1 ? true : false;
    }

    /**
     * Get the login_at attribute.
     *
     * @param  $date
     * @return string
     */
    public function getLastLoginAttribute($date)
    {
        return (is_null($date)) ? null : Carbon::parse($date)->format(config('laravel-user-module.date_format'));
    }

    /**
     * Get the last_login attribute for humans.
     *
     * @return string
     */
    public function getLastLoginForHumansAttribute()
    {
        return (is_null($this->last_login)) ? null : Carbon::parse($this->last_login)->diffForHumans();
    }

    /**
     * Get the login_at attribute for datatable.
     *
     * @return array
     */
    public function getLastLoginTableAttribute()
    {
        return is_null($this->last_login) ? ['display' => '', 'timestamp' => ''] : [
            'display'       => $this->last_login_for_humans,
            'timestamp'     => Carbon::parse($this->last_login)->timestamp,
        ];
    }

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





    /*
    |--------------------------------------------------------------------------
    | Model Events
    |--------------------------------------------------------------------------
    */

    /**
     * model boot method
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * model saved method
         *
         * @param $model
         */
        parent::saved(function($model)
        {
            if (Request::has('roles')) {
                $roles = is_string(Request::get('roles'))
                    ? explode(',',Request::get('roles'))
                    : (
                        ! Request::get('roles') || Request::get('category_id')[0] == 0
                            ? []
                            : Request::get('roles')
                    );
                $model->roles()->sync( $roles );
            }
        });

        /**
         * model deleted method
         *
         * @param $model
         */
        parent::deleted(function($model)
        {
            $file = new FileRepository(config('laravel-user-module.user.uploads'));
            $file->deleteDirectories($model);
        });
    }
}
